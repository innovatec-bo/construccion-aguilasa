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
exports.Map_ = void 0;
const latlng_1 = require("./latlng");
const mvcobject_1 = require("./mvcobject");
// eslint-disable-next-line @typescript-eslint/class-name-casing
class Map_ extends mvcobject_1.MVCObject {
    constructor(mapDiv, opts) {
        super();
        this.fitBounds = jest
            .fn()
            .mockImplementation((bounds, padding) => { });
        this.getBounds = jest
            .fn()
            .mockImplementation(() => null);
        this.getCenter = jest
            .fn()
            .mockImplementation(() => new latlng_1.LatLng({ lat: 0, lng: 0 }));
        this.getDiv = jest.fn().mockImplementation(() => {
            return jest.fn();
        });
        this.getHeading = jest.fn().mockImplementation(() => 0);
        this.getMapTypeId = jest
            .fn()
            .mockImplementation(() => google.maps.MapTypeId.ROADMAP);
        this.getProjection = jest
            .fn()
            .mockImplementation(() => jest.fn());
        this.getStreetView = jest
            .fn()
            .mockImplementation(() => jest.fn());
        this.getTilt = jest.fn().mockImplementation(() => 0);
        this.getZoom = jest.fn().mockImplementation(() => 0);
        this.panBy = jest.fn().mockImplementation((x, y) => { });
        this.panTo = jest
            .fn()
            .mockImplementation((latLng) => { });
        this.panToBounds = jest
            .fn()
            .mockImplementation((latLngBounds, padding) => { });
        this.setCenter = jest
            .fn()
            .mockImplementation((latlng) => { });
        this.setHeading = jest.fn().mockImplementation((heading) => { });
        this.setMapTypeId = jest
            .fn()
            .mockImplementation((mapTypeId) => { });
        this.setOptions = jest
            .fn()
            .mockImplementation((options) => { });
        this.setStreetView = jest
            .fn()
            .mockImplementation((panorama) => { });
        this.setTilt = jest.fn().mockImplementation((tilt) => { });
        this.setZoom = jest.fn().mockImplementation((zoom) => { });
        this.setClickableIcons = jest
            .fn()
            .mockImplementation((clickable) => { });
    }
}
exports.Map_ = Map_;
