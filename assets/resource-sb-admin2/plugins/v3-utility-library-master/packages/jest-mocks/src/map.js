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
var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        if (typeof b !== "function" && b !== null)
            throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
Object.defineProperty(exports, "__esModule", { value: true });
exports.Map_ = void 0;
var latlng_1 = require("./latlng");
var mvcobject_1 = require("./mvcobject");
// eslint-disable-next-line @typescript-eslint/class-name-casing
var Map_ = /** @class */ (function (_super) {
    __extends(Map_, _super);
    function Map_(mapDiv, opts) {
        var _this = _super.call(this) || this;
        _this.fitBounds = jest
            .fn()
            .mockImplementation(function (bounds, padding) { });
        _this.getBounds = jest
            .fn()
            .mockImplementation(function () { return null; });
        _this.getCenter = jest
            .fn()
            .mockImplementation(function () { return new latlng_1.LatLng({ lat: 0, lng: 0 }); });
        _this.getDiv = jest.fn().mockImplementation(function () {
            return jest.fn();
        });
        _this.getHeading = jest.fn().mockImplementation(function () { return 0; });
        _this.getMapTypeId = jest
            .fn()
            .mockImplementation(function () { return google.maps.MapTypeId.ROADMAP; });
        _this.getProjection = jest
            .fn()
            .mockImplementation(function () { return jest.fn(); });
        _this.getStreetView = jest
            .fn()
            .mockImplementation(function () {
            return jest.fn();
        });
        _this.getTilt = jest.fn().mockImplementation(function () { return 0; });
        _this.getZoom = jest.fn().mockImplementation(function () { return 0; });
        _this.panBy = jest.fn().mockImplementation(function (x, y) { });
        _this.panTo = jest
            .fn()
            .mockImplementation(function (latLng) { });
        _this.panToBounds = jest
            .fn()
            .mockImplementation(function (latLngBounds, padding) { });
        _this.setCenter = jest
            .fn()
            .mockImplementation(function (latlng) { });
        _this.setHeading = jest.fn().mockImplementation(function (heading) { });
        _this.setMapTypeId = jest
            .fn()
            .mockImplementation(function (mapTypeId) { });
        _this.setOptions = jest
            .fn()
            .mockImplementation(function (options) { });
        _this.setStreetView = jest
            .fn()
            .mockImplementation(function (panorama) { });
        _this.setTilt = jest.fn().mockImplementation(function (tilt) { });
        _this.setZoom = jest.fn().mockImplementation(function (zoom) { });
        _this.setClickableIcons = jest
            .fn()
            .mockImplementation(function (clickable) { });
        return _this;
    }
    return Map_;
}(mvcobject_1.MVCObject));
exports.Map_ = Map_;
