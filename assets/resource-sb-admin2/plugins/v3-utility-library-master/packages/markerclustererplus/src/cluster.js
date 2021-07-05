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
exports.Cluster = void 0;
var cluster_icon_1 = require("./cluster-icon");
/**
 * Creates a single cluster that manages a group of proximate markers.
 *  Used internally, do not call this constructor directly.
 */
var Cluster = /** @class */ (function () {
    /**
     *
     * @param markerClusterer_ The `MarkerClusterer` object with which this
     *  cluster is associated.
     */
    function Cluster(markerClusterer_) {
        this.markerClusterer_ = markerClusterer_;
        this.map_ = this.markerClusterer_.getMap();
        this.minClusterSize_ = this.markerClusterer_.getMinimumClusterSize();
        this.averageCenter_ = this.markerClusterer_.getAverageCenter();
        this.markers_ = []; // TODO: type;
        this.center_ = null;
        this.bounds_ = null;
        this.clusterIcon_ = new cluster_icon_1.ClusterIcon(this, this.markerClusterer_.getStyles());
    }
    /**
     * Returns the number of markers managed by the cluster. You can call this from
     * a `click`, `mouseover`, or `mouseout` event handler for the `MarkerClusterer` object.
     *
     * @return The number of markers in the cluster.
     */
    Cluster.prototype.getSize = function () {
        return this.markers_.length;
    };
    /**
     * Returns the array of markers managed by the cluster. You can call this from
     * a `click`, `mouseover`, or `mouseout` event handler for the `MarkerClusterer` object.
     *
     * @return The array of markers in the cluster.
     */
    Cluster.prototype.getMarkers = function () {
        return this.markers_;
    };
    /**
     * Returns the center of the cluster. You can call this from
     * a `click`, `mouseover`, or `mouseout` event handler
     * for the `MarkerClusterer` object.
     *
     * @return The center of the cluster.
     */
    Cluster.prototype.getCenter = function () {
        return this.center_;
    };
    /**
     * Returns the map with which the cluster is associated.
     *
     * @return The map.
     * @ignore
     */
    Cluster.prototype.getMap = function () {
        return this.map_;
    };
    /**
     * Returns the `MarkerClusterer` object with which the cluster is associated.
     *
     * @return The associated marker clusterer.
     * @ignore
     */
    Cluster.prototype.getMarkerClusterer = function () {
        return this.markerClusterer_;
    };
    /**
     * Returns the bounds of the cluster.
     *
     * @return the cluster bounds.
     * @ignore
     */
    Cluster.prototype.getBounds = function () {
        var bounds = new google.maps.LatLngBounds(this.center_, this.center_);
        var markers = this.getMarkers();
        for (var i = 0; i < markers.length; i++) {
            bounds.extend(markers[i].getPosition());
        }
        return bounds;
    };
    /**
     * Removes the cluster from the map.
     *
     * @ignore
     */
    Cluster.prototype.remove = function () {
        this.clusterIcon_.setMap(null);
        this.markers_ = [];
        delete this.markers_;
    };
    /**
     * Adds a marker to the cluster.
     *
     * @param marker The marker to be added.
     * @return True if the marker was added.
     * @ignore
     */
    Cluster.prototype.addMarker = function (marker) {
        if (this.isMarkerAlreadyAdded_(marker)) {
            return false;
        }
        if (!this.center_) {
            this.center_ = marker.getPosition();
            this.calculateBounds_();
        }
        else {
            if (this.averageCenter_) {
                var l = this.markers_.length + 1;
                var lat = (this.center_.lat() * (l - 1) + marker.getPosition().lat()) / l;
                var lng = (this.center_.lng() * (l - 1) + marker.getPosition().lng()) / l;
                this.center_ = new google.maps.LatLng(lat, lng);
                this.calculateBounds_();
            }
        }
        marker.isAdded = true;
        this.markers_.push(marker);
        var mCount = this.markers_.length;
        var mz = this.markerClusterer_.getMaxZoom();
        if (mz !== null && this.map_.getZoom() > mz) {
            // Zoomed in past max zoom, so show the marker.
            if (marker.getMap() !== this.map_) {
                marker.setMap(this.map_);
            }
        }
        else if (mCount < this.minClusterSize_) {
            // Min cluster size not reached so show the marker.
            if (marker.getMap() !== this.map_) {
                marker.setMap(this.map_);
            }
        }
        else if (mCount === this.minClusterSize_) {
            // Hide the markers that were showing.
            for (var i = 0; i < mCount; i++) {
                this.markers_[i].setMap(null);
            }
        }
        else {
            marker.setMap(null);
        }
        return true;
    };
    /**
     * Determines if a marker lies within the cluster's bounds.
     *
     * @param marker The marker to check.
     * @return True if the marker lies in the bounds.
     * @ignore
     */
    Cluster.prototype.isMarkerInClusterBounds = function (marker) {
        return this.bounds_.contains(marker.getPosition());
    };
    /**
     * Calculates the extended bounds of the cluster with the grid.
     */
    Cluster.prototype.calculateBounds_ = function () {
        var bounds = new google.maps.LatLngBounds(this.center_, this.center_);
        this.bounds_ = this.markerClusterer_.getExtendedBounds(bounds);
    };
    /**
     * Updates the cluster icon.
     */
    Cluster.prototype.updateIcon = function () {
        var mCount = this.markers_.length;
        var mz = this.markerClusterer_.getMaxZoom();
        if (mz !== null && this.map_.getZoom() > mz) {
            this.clusterIcon_.hide();
            return;
        }
        if (mCount < this.minClusterSize_) {
            // Min cluster size not yet reached.
            this.clusterIcon_.hide();
            return;
        }
        var numStyles = this.markerClusterer_.getStyles().length;
        var sums = this.markerClusterer_.getCalculator()(this.markers_, numStyles);
        this.clusterIcon_.setCenter(this.center_);
        this.clusterIcon_.useStyle(sums);
        this.clusterIcon_.show();
    };
    /**
     * Determines if a marker has already been added to the cluster.
     *
     * @param marker The marker to check.
     * @return True if the marker has already been added.
     */
    Cluster.prototype.isMarkerAlreadyAdded_ = function (marker) {
        if (this.markers_.indexOf) {
            return this.markers_.indexOf(marker) !== -1;
        }
        else {
            for (var i = 0; i < this.markers_.length; i++) {
                if (marker === this.markers_[i]) {
                    return true;
                }
            }
        }
        return false;
    };
    return Cluster;
}());
exports.Cluster = Cluster;
