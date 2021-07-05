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
exports.Marker = void 0;
var mvcobject_1 = require("./mvcobject");
var index_1 = require("./index");
var Marker = /** @class */ (function (_super) {
    __extends(Marker, _super);
    function Marker(opts) {
        var _this = _super.call(this) || this;
        _this.getAnimation = jest
            .fn()
            .mockImplementation(function () { return null; });
        _this.getClickable = jest.fn().mockImplementation(function () { return null; });
        _this.getCursor = jest
            .fn()
            .mockImplementation(function () { return null; });
        _this.getDraggable = jest
            .fn()
            .mockImplementation(function () { return null; });
        _this.getIcon = jest
            .fn()
            .mockImplementation(function () { return null; });
        _this.getLabel = jest
            .fn()
            .mockImplementation(function () { return null; });
        _this.getMap = jest
            .fn()
            .mockImplementation(function () {
            return null;
        });
        _this.getOpacity = jest
            .fn()
            .mockImplementation(function () { return null; });
        _this.getPosition = jest
            .fn()
            .mockImplementation(function () {
            return new index_1.LatLng({ lat: 0, lng: 0 });
        });
        _this.getShape = jest
            .fn()
            .mockImplementation(function () { return null; });
        _this.getTitle = jest
            .fn()
            .mockImplementation(function () { return null; });
        _this.getVisible = jest.fn().mockImplementation(function () { return null; });
        _this.getZIndex = jest
            .fn()
            .mockImplementation(function () { return null; });
        _this.setAnimation = jest
            .fn()
            .mockImplementation(function (animation) { });
        _this.setClickable = jest.fn().mockImplementation(function (flag) { });
        _this.setCursor = jest.fn().mockImplementation(function (cursor) { });
        _this.setDraggable = jest
            .fn()
            .mockImplementation(function (flag) { });
        _this.setIcon = jest
            .fn()
            .mockImplementation(function (icon) { });
        _this.setLabel = jest
            .fn()
            .mockImplementation(function (label) { });
        _this.setMap = jest
            .fn()
            .mockImplementation(function (map) { });
        _this.setOpacity = jest
            .fn()
            .mockImplementation(function (opacity) { });
        _this.setOptions = jest
            .fn()
            .mockImplementation(function (options) { });
        _this.setPosition = jest
            .fn()
            .mockImplementation(function (latlng) { });
        _this.setShape = jest
            .fn()
            .mockImplementation(function (shape) { });
        _this.setTitle = jest.fn().mockImplementation(function (title) { });
        _this.setVisible = jest.fn().mockImplementation(function (visible) { });
        _this.setZIndex = jest.fn().mockImplementation(function (zIndex) { });
        _this.addListener = jest
            .fn()
            .mockImplementation(function (eventName, handler) {
            return jest.fn();
        });
        return _this;
    }
    return Marker;
}(mvcobject_1.MVCObject));
exports.Marker = Marker;
