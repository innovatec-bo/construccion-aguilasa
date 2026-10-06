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
exports.initialize = exports.LatLngBounds = exports.LatLng = exports.MVCObject = exports.Size = exports.Map = exports.Marker = void 0;
/* eslint-disable @typescript-eslint/no-explicit-any */
const latlng_1 = require("./latlng");
Object.defineProperty(exports, "LatLng", { enumerable: true, get: function () { return latlng_1.LatLng; } });
Object.defineProperty(exports, "LatLngBounds", { enumerable: true, get: function () { return latlng_1.LatLngBounds; } });
const map_1 = require("./map");
Object.defineProperty(exports, "Map", { enumerable: true, get: function () { return map_1.Map_; } });
const marker_1 = require("./marker");
Object.defineProperty(exports, "Marker", { enumerable: true, get: function () { return marker_1.Marker; } });
const mvcobject_1 = require("./mvcobject");
Object.defineProperty(exports, "MVCObject", { enumerable: true, get: function () { return mvcobject_1.MVCObject; } });
const point_1 = require("./point");
const size_1 = require("./size");
Object.defineProperty(exports, "Size", { enumerable: true, get: function () { return size_1.Size; } });
const initialize = function () {
    global.google = {
        maps: {
            ImageMapType: jest.fn(),
            Marker: marker_1.Marker,
            Map: map_1.Map_,
            Point: point_1.Point,
            Size: size_1.Size,
            MVCObject: mvcobject_1.MVCObject,
            LatLng: latlng_1.LatLng,
            LatLngBounds: latlng_1.LatLngBounds,
            event: {
                addListener: jest.fn(),
                addListenerOnce: jest.fn(),
                addDomListerner: jest.fn(),
                addDomListernerOnce: jest.fn(),
                clearInstanceListeners: jest.fn(),
                clearListeners: jest.fn(),
                removeListener: jest.fn(),
                trigger: jest.fn()
            }
        }
    };
};
exports.initialize = initialize;
