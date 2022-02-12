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
/// <reference types="@types/jest" />
/// <reference types="@types/googlemaps" />
/* eslint-disable @typescript-eslint/no-explicit-any */
var markermanager_1 = require("./markermanager");
var jest_mocks_1 = require("@googlemaps/jest-mocks");
var gridbounds_1 = require("./gridbounds");
beforeEach(function () {
    jest_mocks_1.initialize();
});
test("can construct MarkerManager", function () {
    var zoom = 10;
    var map = new google.maps.Map(null);
    map.getZoom.mockReturnValueOnce(zoom);
    var mm = new markermanager_1.MarkerManager(map, {});
    expect(map.getZoom).toHaveBeenCalledTimes(1);
    expect(mm["_mapZoom"]).toBe(zoom);
});
test("can add and remove markers", function () {
    var map = new google.maps.Map(null);
    var mm = new markermanager_1.MarkerManager(map, {});
    var marker = new google.maps.Marker();
    marker.setPosition({ lat: 0, lng: 0 });
    mm["_shownBounds"] = new gridbounds_1.GridBounds([new google.maps.Point(-10, -10), new google.maps.Point(10, 10)], 6);
    mm.addMarker(marker, 0, 10);
    expect(mm.shownMarkers).toBe(1);
    expect(mm.getMarker(0, 0, 0)).toBe(marker);
    mm.removeMarker(marker);
});
