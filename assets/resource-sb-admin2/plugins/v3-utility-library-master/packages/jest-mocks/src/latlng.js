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
exports.LatLngBounds = exports.LatLng = void 0;
var LatLng = /** @class */ (function () {
    function LatLng(literal, noWrap) {
        this.equals = jest
            .fn()
            .mockImplementation(function (other) { return false; });
        this.lat = jest.fn().mockImplementation(function () { return 0; });
        this.lng = jest.fn().mockImplementation(function () { return 0; });
        this.toString = jest.fn().mockImplementation(function () { return ""; });
        this.toUrlValue = jest.fn().mockImplementation(function (precision) { return ""; });
        this.toJSON = jest.fn().mockImplementation(function () {
            return { lat: 0, lng: 0 };
        });
    }
    return LatLng;
}());
exports.LatLng = LatLng;
var LatLngBounds = /** @class */ (function () {
    function LatLngBounds(sw, ne) {
        var _this = this;
        this.contains = jest
            .fn()
            .mockImplementation(function (latLng) { return false; });
        this.equals = jest
            .fn()
            .mockImplementation(function (other) { return false; });
        this.extend = jest
            .fn()
            .mockImplementation(function (point) { return _this; });
        this.getCenter = jest
            .fn()
            .mockImplementation(function () { return new google.maps.LatLng({ lat: 0, lng: 0 }); });
        this.getNorthEast = jest
            .fn()
            .mockImplementation(function () { return new google.maps.LatLng({ lat: 0, lng: 0 }); });
        this.getSouthWest = jest
            .fn()
            .mockImplementation(function () { return new google.maps.LatLng({ lat: 0, lng: 0 }); });
        this.intersects = jest
            .fn()
            .mockImplementation(function (other) { return false; });
        this.isEmpty = jest.fn().mockImplementation(function () { return false; });
        this.toJSON = jest.fn().mockImplementation(function () {
            return { east: 0, north: 0, south: 0, west: 0 };
        });
        this.toSpan = jest
            .fn()
            .mockImplementation(function () { return new google.maps.LatLng({ lat: 0, lng: 0 }); });
        this.toString = jest.fn().mockImplementation(function () { return ""; });
        this.toUrlValue = jest.fn().mockImplementation(function (precision) { return ""; });
        this.union = jest
            .fn()
            .mockImplementation(function (other) { return _this; });
    }
    return LatLngBounds;
}());
exports.LatLngBounds = LatLngBounds;
