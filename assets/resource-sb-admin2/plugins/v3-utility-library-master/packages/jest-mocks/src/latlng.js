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
class LatLng {
    constructor(literal, noWrap) {
        this.equals = jest
            .fn()
            .mockImplementation((other) => false);
        this.lat = jest.fn().mockImplementation(() => 0);
        this.lng = jest.fn().mockImplementation(() => 0);
        this.toString = jest.fn().mockImplementation(() => "");
        this.toUrlValue = jest.fn().mockImplementation((precision) => "");
        this.toJSON = jest.fn().mockImplementation(() => {
            return { lat: 0, lng: 0 };
        });
    }
}
exports.LatLng = LatLng;
class LatLngBounds {
    constructor(sw, ne) {
        this.contains = jest
            .fn()
            .mockImplementation((latLng) => false);
        this.equals = jest
            .fn()
            .mockImplementation((other) => false);
        this.extend = jest
            .fn()
            .mockImplementation((point) => this);
        this.getCenter = jest
            .fn()
            .mockImplementation(() => new google.maps.LatLng({ lat: 0, lng: 0 }));
        this.getNorthEast = jest
            .fn()
            .mockImplementation(() => new google.maps.LatLng({ lat: 0, lng: 0 }));
        this.getSouthWest = jest
            .fn()
            .mockImplementation(() => new google.maps.LatLng({ lat: 0, lng: 0 }));
        this.intersects = jest
            .fn()
            .mockImplementation((other) => false);
        this.isEmpty = jest.fn().mockImplementation(() => false);
        this.toJSON = jest.fn().mockImplementation(() => {
            return { east: 0, north: 0, south: 0, west: 0 };
        });
        this.toSpan = jest
            .fn()
            .mockImplementation(() => new google.maps.LatLng({ lat: 0, lng: 0 }));
        this.toString = jest.fn().mockImplementation(() => "");
        this.toUrlValue = jest.fn().mockImplementation((precision) => "");
        this.union = jest
            .fn()
            .mockImplementation((other) => this);
    }
}
exports.LatLngBounds = LatLngBounds;
