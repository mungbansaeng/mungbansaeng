const _version = 'v1';
const CACHE_NAME = 'nconnet-v1.1';
const filesToCache = [
  '/mungInfo'
];

const log = msg => {
  console.log(`[ServiceWorker ${_version}] ${msg}`);
}

// Life cycle: INSTALL
self.addEventListener("install", (event) => {
  console.dir("INSTALL");

  event.waitUntil(
    //끝나기 전까지는 이벤트가 끝나지 않는다.
    //caches 브라우져 예약어
    caches
      .open(CACHE_NAME)
      .then((cache) => {
        //캐쉬를 열고 접근 할 수 있는 캐쉬를 얻을 수 있다.
        //캐쉬에 넣어라
        return cache.addAll(filesToCache);
      })
      .catch((error) => {
        return console.log(error);
      })
  );

});

// Life cycle: ACTIVATE
self.addEventListener("activate", (event) => {

  const newCacheList = [CACHE_NAME];

  event.waitUntil(
    //promise를 리턴 하기 전짜기 동작을 보당 해준다.
    caches
      .keys()
      .then((cacheList) => {
        return Promise.all(
          cacheList.map((cacheName) => {
            if (newCacheList.indexOf(cacheName) === -1) {
              return caches.delete(cacheName);
            }
          })
        );
      })
      .catch(console.error)
  );
});

// Functional: FETCH
self.addEventListener("fetch", (event) => {
  console.log("fetch", event.request.url);
    
  if ("navigate" !== event.request.mode) return;
  
  event.respondWith(
    caches
      .match(event.request) //fetch request를 보내는 내용
      //값이 있다면 캐쉬 내용을 전달 하고
      .open(CACHE_NAME)
      //없다면 fetch 요청을 보내서 자원을 요청한다.
      .then((response) => response || fetch(event.request))
      .catch(console.error)
  );
});

self.addEventListener('push', function(event) {

  console.log('[Service Worker] Push Received.');

  console.log(`[Service Worker] Push had this data: "${event.data.text()}"`);
    
  const title = '멍반생';

  const options = {

    body: event.data.text(), 

    icon: '/pwa/images/icon_512.png',

    badge: '/pwa/images/icon_512.png'

  };



  event.waitUntil(self.registration.showNotification(title, options));

});

self.addEventListener('notificationclick', function(event) {

  console.log('[Service Worker] Notification click Received.');

  event.notification.close();

  event.waitUntil(

  clients.openWindow('https://nconnet.cafe24.com')

  );

});






