import createApp from '@shopify/app-bridge';

const app = createApp({
    apiKey: AppContext.appKey,
    shopOrigin: AppContext.shopUrl,
});
