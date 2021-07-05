"use strict";
/**
 * Copyright 2019 Google LLC. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
Object.defineProperty(exports, "__esModule", { value: true });
exports.MarkerManager = void 0;
/// <reference types="@types/googlemaps" />
var utils_1 = require("./utils");
var gridbounds_1 = require("./gridbounds");
/**
 * Creates a new MarkerManager that will show/hide markers on a map.
 */
var MarkerManager = /** @class */ (function () {
    /**
     * @constructor
     * @param map The map to manage.
     * @param {Options} options
     */
    function MarkerManager(map, _a) {
        var _this = this;
        var _b = _a.maxZoom, maxZoom = _b === void 0 ? 19 : _b, trackMarkers = _a.trackMarkers, _c = _a.shown, shown = _c === void 0 ? true : _c, _d = _a.borderPadding, borderPadding = _d === void 0 ? 100 : _d;
        this._tileSize = 1024;
        this._map = map;
        this._mapZoom = map.getZoom();
        this._maxZoom = maxZoom;
        this._trackMarkers = trackMarkers;
        // The padding in pixels beyond the viewport, where we will pre-load markers.
        this._swPadding = new google.maps.Size(-borderPadding, borderPadding);
        this._nePadding = new google.maps.Size(borderPadding, -borderPadding);
        this._gridWidth = {};
        this._grid = [];
        this._grid[this._maxZoom] = [];
        this._numMarkers = {};
        this._numMarkers[this._maxZoom] = 0;
        this.shownMarkers = 0;
        this.shown = shown;
        google.maps.event.addListenerOnce(map, "idle", function () {
            _this._initialize();
        });
    }
    MarkerManager.prototype._initialize = function () {
        var mapTypes = this._map.mapTypes;
        // Find max zoom level
        var mapMaxZoom = 1;
        for (var sType in mapTypes) {
            if (sType in mapTypes &&
                mapTypes.get(sType) &&
                mapTypes.get(sType).maxZoom === "number") {
                var mapTypeMaxZoom = this._map.mapTypes.get(sType).maxZoom;
                if (mapTypeMaxZoom > mapMaxZoom) {
                    mapMaxZoom = mapTypeMaxZoom;
                }
            }
        }
        google.maps.event.addListener(this._map, "dragend", this._onMapMoveEnd.bind(this));
        google.maps.event.addListener(this._map, "idle", this._onMapMoveEnd.bind(this));
        google.maps.event.addListener(this._map, "zoom_changed", this._onMapMoveEnd.bind(this));
        this.resetManager();
        this._shownBounds = this._getMapGridBounds();
        google.maps.event.trigger(this, "loaded");
    };
    /**
     * This closure provide easy access to the map.
     * They are used as callbacks, not as methods.
     * @param marker Marker to be removed from the map
     */
    MarkerManager.prototype._removeOverlay = function (marker) {
        marker.setMap(null);
        this.shownMarkers--;
    };
    /**
     * This closure provide easy access to the map.
     * They are used as callbacks, not as methods.
     * @param marker Marker to be added to the map
     */
    MarkerManager.prototype._addOverlay = function (marker) {
        if (this.shown) {
            marker.setMap(this._map);
            this.shownMarkers++;
        }
    };
    /**
     * Initializes MarkerManager arrays for all zoom levels
     * Called by constructor and by clearAllMarkers
     */
    MarkerManager.prototype.resetManager = function () {
        var mapWidth = 256;
        for (var zoom = 0; zoom <= this._maxZoom; ++zoom) {
            this._grid[zoom] = [];
            this._numMarkers[zoom] = 0;
            this._gridWidth[zoom] = Math.ceil(mapWidth / this._tileSize);
            mapWidth <<= 1;
        }
    };
    /**
     * Removes all markers in the manager, and
     * removes any visible markers from the map.
     */
    MarkerManager.prototype.clearMarkers = function () {
        this._processAll(this._shownBounds, this._removeOverlay.bind(this));
        this.resetManager();
    };
    /**
     * Gets the tile coordinate for a given latlng point.
     *
     * @param {LatLng} latlng The geographical point.
     * @param {Number} zoom The zoom level.
     * @param {google.maps.Size} padding The padding used to shift the pixel coordinate.
     *               Used for expanding a bounds to include an extra padding
     *               of pixels surrounding the bounds.
     * @return {GPoint} The point in tile coordinates.
     *
     */
    MarkerManager.prototype._getTilePoint = function (latlng, zoom, padding) {
        var pixelPoint = utils_1.latLngToPixel(latlng, zoom);
        var point = new google.maps.Point(Math.floor((pixelPoint.x + padding.width) / this._tileSize), Math.floor((pixelPoint.y + padding.height) / this._tileSize));
        return point;
    };
    /**
     * Finds the appropriate place to add the marker to the grid.
     * Optimized for speed; does not actually add the marker to the map.
     * Designed for batch-_processing thousands of markers.
     *
     * @param {Marker} marker The marker to add.
     * @param {Number} minZoom The minimum zoom for displaying the marker.
     * @param {Number} maxZoom The maximum zoom for displaying the marker.
     */
    MarkerManager.prototype._addMarkerBatch = function (marker, minZoom, maxZoom) {
        var mPoint = marker.getPosition();
        marker.set("__minZoom", minZoom);
        // Tracking markers is expensive, so we do this only if the
        // user explicitly requested it when creating marker manager.
        if (this._trackMarkers) {
            google.maps.event.addListener(marker, "changed", function (a, b, c) {
                this._onMarkerMoved(a, b, c);
            });
        }
        var gridPoint = this._getTilePoint(mPoint, maxZoom, new google.maps.Size(0, 0));
        for (var zoom = maxZoom; zoom >= minZoom; zoom--) {
            var cell = this._getGridCellCreate(gridPoint.x, gridPoint.y, zoom);
            cell.push(marker);
            gridPoint.x = gridPoint.x >> 1;
            gridPoint.y = gridPoint.y >> 1;
        }
    };
    /**
     * Returns whether or not the given point is visible in the shown bounds. This
     * is a helper method that takes care of the corner case, when shownBounds have
     * negative minX value.
     *
     * @param {Point} point a point on a grid.
     * @return {Boolean} Whether or not the given point is visible in the currently
     * shown bounds.
     */
    MarkerManager.prototype._isGridPointVisible = function (point) {
        var vertical = this._shownBounds.minY <= point.y && point.y <= this._shownBounds.maxY;
        var minX = this._shownBounds.minX;
        var horizontal = minX <= point.x && point.x <= this._shownBounds.maxX;
        if (!horizontal && minX < 0) {
            // Shifts the negative part of the rectangle. As point.x is always less
            // than grid width, only test shifted minX .. 0 part of the shown bounds.
            var width = this._gridWidth[this._shownBounds.z];
            horizontal = minX + width <= point.x && point.x <= width - 1;
        }
        return vertical && horizontal;
    };
    /**
     * Reacts to a notification from a marker that it has moved to a new location.
     * It scans the grid all all zoom levels and moves the marker from the old grid
     * location to a new grid location.
     *
     * @param {Marker} marker The marker that moved.
     * @param {LatLng} oldPoint The old position of the marker.
     * @param {LatLng} newPoint The new position of the marker.
     */
    MarkerManager.prototype._onMarkerMoved = function (marker, oldPoint, newPoint) {
        // NOTE: We do not know the minimum or maximum zoom the marker was
        // added at, so we start at the absolute maximum. Whenever we successfully
        // remove a marker at a given zoom, we add it at the new grid coordinates.
        var zoom = this._maxZoom;
        var changed = false;
        var oldGrid = this._getTilePoint(oldPoint, zoom, new google.maps.Size(0, 0));
        var newGrid = this._getTilePoint(newPoint, zoom, new google.maps.Size(0, 0));
        while (zoom >= 0 && (oldGrid.x !== newGrid.x || oldGrid.y !== newGrid.y)) {
            var cell = this._getGridCellNoCreate(oldGrid.x, oldGrid.y, zoom);
            if (cell) {
                if (this._removeMarkerFromCell(cell, marker)) {
                    this._getGridCellCreate(newGrid.x, newGrid.y, zoom).push(marker);
                }
            }
            // For the current zoom we also need to update the map. Markers that no
            // longer are visible are removed from the map. Markers that moved into
            // the shown bounds are added to the map. This also lets us keep the count
            // of visible markers up to date.
            if (zoom === this._mapZoom) {
                if (this._isGridPointVisible(oldGrid)) {
                    if (!this._isGridPointVisible(newGrid)) {
                        this._removeOverlay(marker);
                        changed = true;
                    }
                }
                else {
                    if (this._isGridPointVisible(newGrid)) {
                        this._addOverlay(marker);
                        changed = true;
                    }
                }
            }
            oldGrid.x = oldGrid.x >> 1;
            oldGrid.y = oldGrid.y >> 1;
            newGrid.x = newGrid.x >> 1;
            newGrid.y = newGrid.y >> 1;
            --zoom;
        }
        if (changed) {
            this._notifyListeners();
        }
    };
    /**
     * Removes marker from the manager and from the map
     * (if it's currently visible).
     * @param {GMarker} marker The marker to delete.
     */
    MarkerManager.prototype.removeMarker = function (marker) {
        var zoom = this._maxZoom;
        var changed = false;
        var point = marker.getPosition();
        var grid = this._getTilePoint(point, zoom, new google.maps.Size(0, 0));
        while (zoom >= 0) {
            var cell = this._getGridCellNoCreate(grid.x, grid.y, zoom);
            if (cell) {
                this._removeMarkerFromCell(cell, marker);
            }
            // For the current zoom we also need to update the map. Markers that no
            // longer are visible are removed from the map. This also lets us keep the count
            // of visible markers up to date.
            if (zoom === this._mapZoom) {
                if (this._isGridPointVisible(grid)) {
                    this._removeOverlay(marker);
                    changed = true;
                }
            }
            grid.x = grid.x >> 1;
            grid.y = grid.y >> 1;
            --zoom;
        }
        if (changed) {
            this._notifyListeners();
        }
        this._numMarkers[marker.get("__minZoom")]--;
    };
    /**
     * Add many markers at once.
     * Does not actually update the map, just the internal grid.
     *
     * @param {Array of Marker} markers The markers to add.
     * @param {Number} minZoom The minimum zoom level to display the markers.
     * @param {Number} maxZoom The maximum zoom level to display the markers.
     */
    MarkerManager.prototype.addMarkers = function (markers, minZoom, maxZoom) {
        maxZoom = this._getOptmaxZoom(maxZoom);
        for (var i = markers.length - 1; i >= 0; i--) {
            this._addMarkerBatch(markers[i], minZoom, maxZoom);
        }
        this._numMarkers[minZoom] += markers.length;
    };
    /**
     * Returns the value of the optional maximum zoom. This method is defined so
     * that we have just one place where optional maximum zoom is calculated.
     *
     * @param {Number} maxZoom The optinal maximum zoom.
     * @return The maximum zoom.
     */
    MarkerManager.prototype._getOptmaxZoom = function (maxZoom) {
        return maxZoom || this._maxZoom;
    };
    /**
     * Calculates the total number of markers potentially visible at a given
     * zoom level.
     *
     * @param {Number} zoom The zoom level to check.
     */
    MarkerManager.prototype.getMarkerCount = function (zoom) {
        var total = 0;
        for (var z = 0; z <= zoom; z++) {
            total += this._numMarkers[z];
        }
        return total;
    };
    /**
     * Returns a marker given latitude, longitude and zoom. If the marker does not
     * exist, the method will return a new marker. If a new marker is created,
     * it will NOT be added to the manager.
     *
     * @param {Number} lat - the latitude of a marker.
     * @param {Number} lng - the longitude of a marker.
     * @param {Number} zoom - the zoom level
     * @return {GMarker} marker - the marker found at lat and lng
     */
    MarkerManager.prototype.getMarker = function (lat, lng, zoom) {
        var mPoint = new google.maps.LatLng(lat, lng);
        var gridPoint = this._getTilePoint(mPoint, zoom, new google.maps.Size(0, 0));
        var marker = new google.maps.Marker({ position: mPoint });
        var cell = this._getGridCellNoCreate(gridPoint.x, gridPoint.y, zoom);
        if (cell !== undefined) {
            for (var i = 0; i < cell.length; i++) {
                if (lat === cell[i].getPosition().lat() &&
                    lng === cell[i].getPosition().lng()) {
                    marker = cell[i];
                }
            }
        }
        return marker;
    };
    /**
     * Add a single marker to the map.
     *
     * @param {Marker} marker The marker to add.
     * @param {Number} minZoom The minimum zoom level to display the marker.
     * @param {Number} maxZoom The maximum zoom level to display the marker.
     */
    MarkerManager.prototype.addMarker = function (marker, minZoom, maxZoom) {
        maxZoom = this._getOptmaxZoom(maxZoom);
        this._addMarkerBatch(marker, minZoom, maxZoom);
        var gridPoint = this._getTilePoint(marker.getPosition(), this._mapZoom, new google.maps.Size(0, 0));
        if (this._isGridPointVisible(gridPoint) &&
            minZoom <= this._shownBounds.z &&
            this._shownBounds.z <= maxZoom) {
            this._addOverlay(marker);
            this._notifyListeners();
        }
        this._numMarkers[minZoom]++;
    };
    /**
     * Get a cell in the grid, creating it first if necessary.
     *
     * Optimization candidate
     *
     * @param {Number} x The x coordinate of the cell.
     * @param {Number} y The y coordinate of the cell.
     * @param {Number} z The z coordinate of the cell.
     * @return {Array} The cell in the array.
     */
    MarkerManager.prototype._getGridCellCreate = function (x, y, z) {
        // TODO(jpoehnelt) document this
        if (x < 0) {
            x += this._gridWidth[z];
        }
        if (!this._grid[z]) {
            this._grid[z] = [];
        }
        if (!this._grid[z][x]) {
            this._grid[z][x] = [];
        }
        if (!this._grid[z][x][y]) {
            this._grid[z][x][y] = [];
        }
        return this._grid[z][x][y];
    };
    /**
     * Get a cell in the grid, returning undefined if it does not exist.
     *
     * NOTE: Optimized for speed -- otherwise could combine with _getGridCellCreate.
     *
     * @param {Number} x The x coordinate of the cell.
     * @param {Number} y The y coordinate of the cell.
     * @param {Number} z The z coordinate of the cell.
     * @return {Array} The cell in the array.
     */
    MarkerManager.prototype._getGridCellNoCreate = function (x, y, z) {
        if (x < 0) {
            x += this._gridWidth[z];
        }
        if (!this._grid[z]) {
            return null;
        }
        if (!this._grid[z][x]) {
            return null;
        }
        if (!this._grid[z][x][y]) {
            return null;
        }
        return this._grid[z][x][y];
    };
    /**
     * Turns at geographical bounds into a grid-space bounds.
     *
     * @param {LatLngBounds} bounds The geographical bounds.
     * @param {Number} zoom The zoom level of the bounds.
     * @param {google.maps.Size} swPadding The padding in pixels to extend beyond the
     * given bounds.
     * @param {google.maps.Size} nePadding The padding in pixels to extend beyond the
     * given bounds.
     * @return {GridBounds} The bounds in grid space.
     */
    MarkerManager.prototype._getGridBounds = function (bounds, zoom, swPadding, nePadding) {
        zoom = Math.min(zoom, this._maxZoom);
        var bl = bounds.getSouthWest();
        var tr = bounds.getNorthEast();
        var sw = this._getTilePoint(bl, zoom, swPadding);
        var ne = this._getTilePoint(tr, zoom, nePadding);
        var gw = this._gridWidth[zoom];
        // Crossing the prime meridian requires correction of bounds.
        if (tr.lng() < bl.lng() || ne.x < sw.x) {
            sw.x -= gw;
        }
        if (ne.x - sw.x + 1 >= gw) {
            // Computed grid bounds are larger than the world; truncate.
            sw.x = 0;
            ne.x = gw - 1;
        }
        var gridBounds = new gridbounds_1.GridBounds([sw, ne], zoom);
        gridBounds.z = zoom;
        return gridBounds;
    };
    /**
     * Gets the grid-space bounds for the current map viewport.
     *
     * @return {Bounds} The bounds in grid space.
     */
    MarkerManager.prototype._getMapGridBounds = function () {
        return this._getGridBounds(this._map.getBounds(), this._mapZoom, this._swPadding, this._nePadding);
    };
    /**
     * Event listener for map:movend.
     * NOTE: Use a timeout so that the user is not blocked
     * from moving the map.
     *
     * Removed this because a a lack of a scopy override/callback function on events.
     */
    MarkerManager.prototype._onMapMoveEnd = function () {
        window.setTimeout(this._updateMarkers.bind(this), 0);
    };
    /**
     * Is this layer visible?
     *
     * Returns visibility setting
     *
     * @return {Boolean} Visible
     */
    MarkerManager.prototype.visible = function () {
        return this.shown ? true : false;
    };
    /**
     * Returns true if the manager is hidden.
     * Otherwise returns false.
     * @return {Boolean} Hidden
     */
    MarkerManager.prototype.isHidden = function () {
        return !this.shown;
    };
    /**
     * Shows the manager if it's currently hidden.
     */
    MarkerManager.prototype.show = function () {
        this.shown = true;
        this.refresh();
    };
    /**
     * Hides the manager if it's currently visible
     */
    MarkerManager.prototype.hide = function () {
        this.shown = false;
        this.refresh();
    };
    /**
     * Toggles the visibility of the manager.
     */
    MarkerManager.prototype.toggle = function () {
        this.shown = !this.shown;
        this.refresh();
    };
    /**
     * Refresh forces the marker-manager into a good state.
     * <ol>
     *   <li>If never before initialized, shows all the markers.</li>
     *   <li>If previously initialized, removes and re-adds all markers.</li>
     * </ol>
     */
    MarkerManager.prototype.refresh = function () {
        if (this.shownMarkers > 0) {
            this._processAll(this._shownBounds, this._removeOverlay.bind(this));
        }
        // An extra check on this.show to increase performance (no need to _processAll_)
        if (this.show) {
            this._processAll(this._shownBounds, this._addOverlay.bind(this));
        }
        this._notifyListeners();
    };
    /**
     * After the viewport may have changed, add or remove markers as needed.
     */
    MarkerManager.prototype._updateMarkers = function () {
        this._mapZoom = this._map.getZoom();
        var newBounds = this._getMapGridBounds();
        // If the move does not include new grid sections,
        // we have no work to do:
        if (newBounds.equals(this._shownBounds) &&
            newBounds.z === this._shownBounds.z) {
            return;
        }
        if (newBounds.z !== this._shownBounds.z) {
            this._processAll(this._shownBounds, this._removeOverlay.bind(this));
            if (this.show) {
                // performance
                this._processAll(newBounds, this._addOverlay.bind(this));
            }
        }
        else {
            // Remove markers:
            this._rectangleDiff(this._shownBounds, newBounds, this._removeCellMarkers.bind(this));
            // Add markers:
            if (this.show) {
                // performance
                this._rectangleDiff(newBounds, this._shownBounds, this._addCellMarkers.bind(this));
            }
        }
        this._shownBounds = newBounds;
        this._notifyListeners();
    };
    /**
     * Notify listeners when the state of what is displayed changes.
     */
    MarkerManager.prototype._notifyListeners = function () {
        google.maps.event.trigger(this, "changed", this._shownBounds, this.shownMarkers);
    };
    /**
     * Process all markers in the bounds provided, using a callback.
     *
     * @param {Bounds} bounds The bounds in grid space.
     * @param {Function} callback The function to call for each marker.
     */
    MarkerManager.prototype._processAll = function (bounds, callback) {
        for (var x = bounds.minX; x <= bounds.maxX; x++) {
            for (var y = bounds.minY; y <= bounds.maxY; y++) {
                this._processCellMarkers(x, y, bounds.z, callback);
            }
        }
    };
    /**
     * Process all markers in the grid cell, using a callback.
     *
     * @param {Number} x The x coordinate of the cell.
     * @param {Number} y The y coordinate of the cell.
     * @param {Number} z The z coordinate of the cell.
     * @param {Function} callback The function to call for each marker.
     */
    MarkerManager.prototype._processCellMarkers = function (x, y, z, callback) {
        var cell = this._getGridCellNoCreate(x, y, z);
        if (cell) {
            for (var i = cell.length - 1; i >= 0; i--) {
                callback(cell[i]);
            }
        }
    };
    /**
     * Remove all markers in a grid cell.
     *
     * @param {Number} x The x coordinate of the cell.
     * @param {Number} y The y coordinate of the cell.
     * @param {Number} z The z coordinate of the cell.
     */
    MarkerManager.prototype._removeCellMarkers = function (x, y, z) {
        this._processCellMarkers(x, y, z, this._removeOverlay.bind(this));
    };
    /**
     * Add all markers in a grid cell.
     *
     * @param {Number} x The x coordinate of the cell.
     * @param {Number} y The y coordinate of the cell.
     * @param {Number} z The z coordinate of the cell.
     */
    MarkerManager.prototype._addCellMarkers = function (x, y, z) {
        this._processCellMarkers(x, y, z, this._addOverlay.bind(this));
    };
    /**
     * Use the _rectangleDiffCoords function to process all grid cells
     * that are in bounds1 but not bounds2, using a callback, and using
     * the current MarkerManager object as the instance.
     *
     * Pass the z parameter to the callback in addition to x and y.
     *
     * @param {Bounds} bounds1 The bounds of all points we may _process.
     * @param {Bounds} bounds2 The bounds of points to exclude.
     * @param {Function} callback The callback function to call
     *                   for each grid coordinate (x, y, z).
     */
    MarkerManager.prototype._rectangleDiff = function (bounds1, bounds2, callback) {
        this._rectangleDiffCoords(bounds1, bounds2, function (x, y) {
            callback(x, y, bounds1.z);
        });
    };
    /**
     * Calls the function for all points in bounds1, not in bounds2
     *
     * @param {Bounds} bounds1 The bounds of all points we may process.
     * @param {Bounds} bounds2 The bounds of points to exclude.
     * @param {Function} callback The callback function to call
     *                   for each grid coordinate.
     */
    MarkerManager.prototype._rectangleDiffCoords = function (bounds1, bounds2, callback) {
        var minX1 = bounds1.minX;
        var minY1 = bounds1.minY;
        var maxX1 = bounds1.maxX;
        var maxY1 = bounds1.maxY;
        var minX2 = bounds2.minX;
        var minY2 = bounds2.minY;
        var maxX2 = bounds2.maxX;
        var maxY2 = bounds2.maxY;
        var x, y;
        for (x = minX1; x <= maxX1; x++) {
            // All x in R1
            // All above:
            for (y = minY1; y <= maxY1 && y < minY2; y++) {
                // y in R1 above R2
                callback(x, y);
            }
            // All below:
            for (y = Math.max(maxY2 + 1, minY1); // y in R1 below R2
             y <= maxY1; y++) {
                callback(x, y);
            }
        }
        for (y = Math.max(minY1, minY2); y <= Math.min(maxY1, maxY2); y++) {
            // All y in R2 and in R1
            // Strictly left:
            for (x = Math.min(maxX1 + 1, minX2) - 1; x >= minX1; x--) {
                // x in R1 left of R2
                callback(x, y);
            }
            // Strictly right:
            for (x = Math.max(minX1, maxX2 + 1); // x in R1 right of R2
             x <= maxX1; x++) {
                callback(x, y);
            }
        }
    };
    /**
     * Removes marker from cell. O(N).
     */
    MarkerManager.prototype._removeMarkerFromCell = function (cell, marker) {
        var shift = 0;
        for (var i = 0; i < cell.length; ++i) {
            if (cell[i] === marker) {
                cell.splice(i--, 1);
                shift++;
            }
        }
        return shift;
    };
    return MarkerManager;
}());
exports.MarkerManager = MarkerManager;
