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
var __assign = (this && this.__assign) || function () {
    __assign = Object.assign || function(t) {
        for (var s, i = 1, n = arguments.length; i < n; i++) {
            s = arguments[i];
            for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p))
                t[p] = s[p];
        }
        return t;
    };
    return __assign.apply(this, arguments);
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.WmsMapType = exports.xyzToBounds = exports.DEFAULT_WMS_PARAMS = exports.EPSG_3857_EXTENT = void 0;
/// <reference types="@types/googlemaps" />
var query_string_1 = require("query-string");
/**
 * @ignore
 */
var DEFAULT_WMS_PARAMS = {
    request: "GetMap",
    service: "WMS",
    srs: "EPSG:3857"
};
exports.DEFAULT_WMS_PARAMS = DEFAULT_WMS_PARAMS;
/**
 * @ignore
 */
var EPSG_3857_EXTENT = 20037508.34789244;
exports.EPSG_3857_EXTENT = EPSG_3857_EXTENT;
/**
 * @ignore
 */
var ORIG_X = -EPSG_3857_EXTENT; // x starts from right
/**
 * @ignore
 */
var ORIG_Y = EPSG_3857_EXTENT; // y starts from top
/**
 * Convert xyz tile coordinates to mercator bounds.
 *
 * @param x
 * @param y
 * @param zoom
 * @returns {number[]} minx, miny, maxx, maxy
 */
function xyzToBounds(x, y, zoom) {
    var tileSize = (EPSG_3857_EXTENT * 2) / Math.pow(2, zoom);
    var minx = ORIG_X + x * tileSize;
    var maxx = ORIG_X + (x + 1) * tileSize;
    var miny = ORIG_Y - (y + 1) * tileSize;
    var maxy = ORIG_Y - y * tileSize;
    return [minx, miny, maxx, maxy];
}
exports.xyzToBounds = xyzToBounds;
/**
 *
 * @param {WmsMapTypeOptions} params
 */
var WmsMapType = function (_a) {
    var url = _a.url, layers = _a.layers, _b = _a.styles, styles = _b === void 0 ? "" : _b, _c = _a.bgcolor, bgcolor = _c === void 0 ? "0xFFFFFF" : _c, _d = _a.version, version = _d === void 0 ? "1.1.1" : _d, _e = _a.transparent, transparent = _e === void 0 ? true : _e, _f = _a.format, format = _f === void 0 ? "image/png" : _f, _g = _a.outline, outline = _g === void 0 ? false : _g, 
    // google.maps.ImageMapTypeOptions interface
    name = _a.name, alt = _a.alt, maxZoom = _a.maxZoom, minZoom = _a.minZoom, opacity = _a.opacity;
    // currently only support tileSize of 256
    var tileSize = new google.maps.Size(256, 256);
    var params = __assign({ layers: layers, styles: styles, version: version, transparent: transparent, bgcolor: bgcolor, format: format, outline: outline, width: tileSize.width, height: tileSize.height }, DEFAULT_WMS_PARAMS);
    if (url.slice(-1) !== "?") {
        url += "?";
    }
    var getTileUrl = function (coord, zoom) {
        return (url +
            (0, query_string_1.stringify)(__assign({ bbox: xyzToBounds(coord.x, coord.y, zoom).join(",") }, params)));
    };
    return new google.maps.ImageMapType({
        getTileUrl: getTileUrl,
        name: name,
        alt: alt,
        opacity: opacity,
        maxZoom: maxZoom,
        minZoom: minZoom,
        tileSize: tileSize
    });
};
exports.WmsMapType = WmsMapType;
