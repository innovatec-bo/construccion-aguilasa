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
var jest_mocks_1 = require("@googlemaps/jest-mocks");
var wmsmaptype_1 = require("./wmsmaptype");
var query_string_1 = require("query-string");
beforeEach(function () {
    jest_mocks_1.initialize();
});
test("xyzToBounds is correct", function () {
    expect(wmsmaptype_1.xyzToBounds(0, 0, 0)).toEqual([
        -wmsmaptype_1.EPSG_3857_EXTENT,
        -wmsmaptype_1.EPSG_3857_EXTENT,
        wmsmaptype_1.EPSG_3857_EXTENT,
        wmsmaptype_1.EPSG_3857_EXTENT
    ]);
});
test.each([
    [
        {
            url: "https://www.mrlc.gov/geoserver/NLCD_Land_Cover/wms",
            layers: "mrlc_display:NLCD_2016_Land_Cover_L48",
            styles: "mrlc:mrlc_NLCD_2016_Land_Cover_L48_20190424",
            bgcolor: "0xFFFFFF",
            version: "1.2.3",
            format: "image/jpeg",
            outline: true,
            transparent: true,
            name: "Land Cover",
            alt: "NLCD_2016_Land_Cover_L48",
            maxZoom: 18,
            minZoom: 0,
            opacity: 1.0
        }
    ],
    [
        {
            url: "https://www.mrlc.gov/geoserver/NLCD_Land_Cover/wms?",
            layers: "mrlc_display:NLCD_2016_Land_Cover_L48",
            maxZoom: 18
        }
    ]
])("WmsMapType can be called with getTIleUrl", function (options) {
    wmsmaptype_1.WmsMapType(options);
    // need to get the mock in order of each
    var mock = google.maps.ImageMapType.mock;
    var tileUrl = mock.calls[mock.calls.length - 1][0].getTileUrl(new google.maps.Point(0, 0), 1, null);
    var _a = tileUrl.split("?"), base = _a[0], queryString = _a[1];
    expect(base).toEqual("https://www.mrlc.gov/geoserver/NLCD_Land_Cover/wms");
    var params = query_string_1.parse(queryString, {
        parseNumbers: true,
        parseBooleans: true
    });
    expect(params["layers"]).toEqual(options["layers"]);
    expect(params["bgcolor"]).toEqual(parseInt(options["bgcolor"] || "0xFFFFFF"));
    expect(params["styles"]).toEqual(options["styles"] || "");
    expect(params["request"]).toEqual(wmsmaptype_1.DEFAULT_WMS_PARAMS.request);
    expect(params["service"]).toEqual(wmsmaptype_1.DEFAULT_WMS_PARAMS.service);
    expect(params["srs"]).toEqual(wmsmaptype_1.DEFAULT_WMS_PARAMS.srs);
    expect(params["format"]).toEqual(options["format"] || "image/png");
    expect(params["outline"]).toEqual(options["outline"] || false);
    expect(params["version"]).toEqual(options["version"] || "1.1.1");
    expect(params["height"]).toEqual(256);
    expect(params["width"]).toEqual(256);
});
