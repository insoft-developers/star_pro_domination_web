'use strict';
const MANIFEST = 'flutter-app-manifest';
const TEMP = 'flutter-temp-cache';
const CACHE_NAME = 'flutter-app-cache';
const RESOURCES = {
  "assets/AssetManifest.json": "ea0dc5c7da69364d612dac67071e3469",
"assets/assets/fonts/Poppins-Bold.ttf": "08c20a487911694291bd8c5de41315ad",
"assets/assets/fonts/Poppins-Italic.ttf": "c1034239929f4651cc17d09ed3a28c69",
"assets/assets/fonts/Poppins-Light.ttf": "fcc40ae9a542d001971e53eaed948410",
"assets/assets/fonts/Poppins-Regular.ttf": "093ee89be9ede30383f39a899c485a82",
"assets/assets/fonts/Poppins-SemiBold.ttf": "6f1520d107205975713ba09df778f93f",
"assets/FontManifest.json": "4942bea7ef334d967cb9c575d305318f",
"assets/fonts/MaterialIcons-Regular.otf": "7e7a6cccddf6d7b20012a548461d5d81",
"assets/images/banksoalok.png": "8d6b644754105d622215eb03ac3473f9",
"assets/images/bgsplash.png": "13433abf5f4fefd8cbbafd3ffa85f625",
"assets/images/bimbelok.png": "6aac02a7c48da9f24f9b22c3a36d0145",
"assets/images/calendar.png": "46a9340cc4b2ecca10bdee58512b769a",
"assets/images/festival.png": "71afc4bc7cf1109fae6dedc0767abe41",
"assets/images/food.png": "cad68c72a220ff1103c5650d3bb5c761",
"assets/images/hasilbaru.png": "9656ffe10717f4a9d491eaf51dcef67c",
"assets/images/ik.png": "7625369585040b0d0b6e7cde9151f51a",
"assets/images/image_place.png": "1285605207b4481bfe511796f2214b52",
"assets/images/instagram_logo.png": "f7b457fe4ad7a6771b9d2dd70fa6b5fd",
"assets/images/kuisok.png": "95dd2129464743dbdf83c76dbdcef842",
"assets/images/logobaru.png": "f683933e4aaaa0c90dce09683ac9c5ef",
"assets/images/logodatar.png": "f683933e4aaaa0c90dce09683ac9c5ef",
"assets/images/map.png": "76a830c20d58524272aa3e2096124873",
"assets/images/matpem.png": "7c2ab0b13f6d610ae367263ccfab82fd",
"assets/images/murid.png": "e84a95f4c7f9fde348907508a6f60751",
"assets/images/notification.png": "012c87127d05bb9b7e53a7a387d89e03",
"assets/images/profil_image.png": "765012cc5490bbca9c5b66284b90465f",
"assets/images/quiz.png": "bc0d4eb241d37f8bb9154593903ac8a2",
"assets/images/quiz_quiz.png": "43378b717471c033339e2549eedb98e9",
"assets/images/setting.png": "3a7dd09f5ed0e8e6648b814226c719be",
"assets/images/settingok.png": "1e6cfc901d769d9e44d0a93b254c099e",
"assets/images/stest.png": "6930d308c5b80e615a9fc44c0e6f8bb0",
"assets/images/students.png": "3067b1c52c42f5e7c32a33cc419d7a56",
"assets/images/tanyasoalok.png": "514ae88eb242bb73e942eeba25f67402",
"assets/images/todo.png": "a5efa6f70a3e99e905c0327874e922b9",
"assets/images/try1.png": "385e5c269fcc538bef2ae4f7675e3877",
"assets/images/try2.png": "1cde9bd1e47d90473c0f4f56902338ba",
"assets/images/tryoutok.png": "4f51960535615ba061226ed95f17b789",
"assets/images/video_icon.png": "63de69d10edfdc67139ff9108eaced22",
"assets/images/vpem.png": "883f419f02f92479249037deb178b818",
"assets/images/wa.png": "c9c76111698a62994e4d43f2499b20e3",
"assets/images/wa_logo.png": "e35096a684b5ad1fefb08b35064cf9fb",
"assets/NOTICES": "395d719521922f26c863f0a9552b27d9",
"assets/packages/cupertino_icons/assets/CupertinoIcons.ttf": "6d342eb68f170c97609e9da345464e5e",
"assets/packages/flutter_inappwebview/assets/t_rex_runner/t-rex.css": "5a8d0222407e388155d7d1395a75d5b9",
"assets/packages/flutter_inappwebview/assets/t_rex_runner/t-rex.html": "16911fcc170c8af1c5457940bd0bf055",
"assets/packages/youtube_player_flutter/assets/speedometer.webp": "50448630e948b5b3998ae5a5d112622b",
"canvaskit/canvaskit.js": "c2b4e5f3d7a3d82aed024e7249a78487",
"canvaskit/canvaskit.wasm": "4b83d89d9fecbea8ca46f2f760c5a9ba",
"canvaskit/profiling/canvaskit.js": "ae2949af4efc61d28a4a80fffa1db900",
"canvaskit/profiling/canvaskit.wasm": "95e736ab31147d1b2c7b25f11d4c32cd",
"favicon.png": "5dcef449791fa27946b3d35ad8803796",
"icons/Icon-192.png": "ac9a721a12bbc803b44f645561ecb1e1",
"icons/Icon-512.png": "96e752610906ba2a93c65f8abe1645f1",
"icons/Icon-maskable-192.png": "c457ef57daa1d16f64b27b786ec2ea3c",
"icons/Icon-maskable-512.png": "301a7604d45b3e739efc881eb04896ea",
"index.html": "05183e9d97c0b5c50285db8542649d5f",
"/": "05183e9d97c0b5c50285db8542649d5f",
"main.dart.js": "9ce82333d3ad5752ca896b9fc3394556",
"manifest.json": "6a76ae9912164b7eef66c9562b5b21a3",
"version.json": "a268dca5341b8f789c68f60aa11e96ca"
};

// The application shell files that are downloaded before a service worker can
// start.
const CORE = [
  "/",
"main.dart.js",
"index.html",
"assets/NOTICES",
"assets/AssetManifest.json",
"assets/FontManifest.json"];
// During install, the TEMP cache is populated with the application shell files.
self.addEventListener("install", (event) => {
  self.skipWaiting();
  return event.waitUntil(
    caches.open(TEMP).then((cache) => {
      return cache.addAll(
        CORE.map((value) => new Request(value, {'cache': 'reload'})));
    })
  );
});

// During activate, the cache is populated with the temp files downloaded in
// install. If this service worker is upgrading from one with a saved
// MANIFEST, then use this to retain unchanged resource files.
self.addEventListener("activate", function(event) {
  return event.waitUntil(async function() {
    try {
      var contentCache = await caches.open(CACHE_NAME);
      var tempCache = await caches.open(TEMP);
      var manifestCache = await caches.open(MANIFEST);
      var manifest = await manifestCache.match('manifest');
      // When there is no prior manifest, clear the entire cache.
      if (!manifest) {
        await caches.delete(CACHE_NAME);
        contentCache = await caches.open(CACHE_NAME);
        for (var request of await tempCache.keys()) {
          var response = await tempCache.match(request);
          await contentCache.put(request, response);
        }
        await caches.delete(TEMP);
        // Save the manifest to make future upgrades efficient.
        await manifestCache.put('manifest', new Response(JSON.stringify(RESOURCES)));
        return;
      }
      var oldManifest = await manifest.json();
      var origin = self.location.origin;
      for (var request of await contentCache.keys()) {
        var key = request.url.substring(origin.length + 1);
        if (key == "") {
          key = "/";
        }
        // If a resource from the old manifest is not in the new cache, or if
        // the MD5 sum has changed, delete it. Otherwise the resource is left
        // in the cache and can be reused by the new service worker.
        if (!RESOURCES[key] || RESOURCES[key] != oldManifest[key]) {
          await contentCache.delete(request);
        }
      }
      // Populate the cache with the app shell TEMP files, potentially overwriting
      // cache files preserved above.
      for (var request of await tempCache.keys()) {
        var response = await tempCache.match(request);
        await contentCache.put(request, response);
      }
      await caches.delete(TEMP);
      // Save the manifest to make future upgrades efficient.
      await manifestCache.put('manifest', new Response(JSON.stringify(RESOURCES)));
      return;
    } catch (err) {
      // On an unhandled exception the state of the cache cannot be guaranteed.
      console.error('Failed to upgrade service worker: ' + err);
      await caches.delete(CACHE_NAME);
      await caches.delete(TEMP);
      await caches.delete(MANIFEST);
    }
  }());
});

// The fetch handler redirects requests for RESOURCE files to the service
// worker cache.
self.addEventListener("fetch", (event) => {
  if (event.request.method !== 'GET') {
    return;
  }
  var origin = self.location.origin;
  var key = event.request.url.substring(origin.length + 1);
  // Redirect URLs to the index.html
  if (key.indexOf('?v=') != -1) {
    key = key.split('?v=')[0];
  }
  if (event.request.url == origin || event.request.url.startsWith(origin + '/#') || key == '') {
    key = '/';
  }
  // If the URL is not the RESOURCE list then return to signal that the
  // browser should take over.
  if (!RESOURCES[key]) {
    return;
  }
  // If the URL is the index.html, perform an online-first request.
  if (key == '/') {
    return onlineFirst(event);
  }
  event.respondWith(caches.open(CACHE_NAME)
    .then((cache) =>  {
      return cache.match(event.request).then((response) => {
        // Either respond with the cached resource, or perform a fetch and
        // lazily populate the cache.
        return response || fetch(event.request).then((response) => {
          cache.put(event.request, response.clone());
          return response;
        });
      })
    })
  );
});

self.addEventListener('message', (event) => {
  // SkipWaiting can be used to immediately activate a waiting service worker.
  // This will also require a page refresh triggered by the main worker.
  if (event.data === 'skipWaiting') {
    self.skipWaiting();
    return;
  }
  if (event.data === 'downloadOffline') {
    downloadOffline();
    return;
  }
});

// Download offline will check the RESOURCES for all files not in the cache
// and populate them.
async function downloadOffline() {
  var resources = [];
  var contentCache = await caches.open(CACHE_NAME);
  var currentContent = {};
  for (var request of await contentCache.keys()) {
    var key = request.url.substring(origin.length + 1);
    if (key == "") {
      key = "/";
    }
    currentContent[key] = true;
  }
  for (var resourceKey of Object.keys(RESOURCES)) {
    if (!currentContent[resourceKey]) {
      resources.push(resourceKey);
    }
  }
  return contentCache.addAll(resources);
}

// Attempt to download the resource online before falling back to
// the offline cache.
function onlineFirst(event) {
  return event.respondWith(
    fetch(event.request).then((response) => {
      return caches.open(CACHE_NAME).then((cache) => {
        cache.put(event.request, response.clone());
        return response;
      });
    }).catch((error) => {
      return caches.open(CACHE_NAME).then((cache) => {
        return cache.match(event.request).then((response) => {
          if (response != null) {
            return response;
          }
          throw error;
        });
      });
    })
  );
}
