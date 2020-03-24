require.config({
    baseUrl: '../',
    paths: {
        'geoJson': '../geoData/geoJson',
        'theme': '../front',
        'data': './data',
        'map': '../map',
        'extension': '../extension'
    },
    packages: [
        {
            main: 'echarts',
            location: '../src',
            name: 'echarts'
        },
        {
            main: 'zrender',
            location: '../../zrender/src',
            name: 'zrender'
        }
    ]
    // urlArgs: '_v_=' + +new Date()
});
