<style>
    @font-face {
        font-family: 'Roboto';
        font-style: normal;
        font-weight: 400;
        src: url('{{ public_path('core/fonts/Roboto/Roboto-Regular.ttf') }}') format('truetype');
    }

    @font-face {
        font-family: 'Roboto';
        font-style: bold;
        font-weight: 700;
        src: url('{{ public_path('core/fonts/Roboto/Roboto-SemiBold.ttf') }}') format('truetype');
    }

    @font-face {
        font-family: 'Roboto';
        font-style: italic;
        font-weight: 400;
        src: url('{{ public_path('core/fonts/Roboto/Roboto-Italic.ttf') }}') format('truetype');
    }

    * {
        margin: 0;
        padding: 0;

        font-family: 'Roboto', sans-serif;
    }

    @page {
        /* margin: 10px; */
    }

    body {
        margin: 0;
        padding: 25px;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        margin: 0;
        padding: 0;
        line-height: 0.6;
        font-weight: 700;
        font-family: 'Roboto', sans-serif;
    }

    p,
    th,
    td {
        margin: 0;
        padding: 0;
        font-weight: 400;
        line-height: 0.7;
        padding-bottom: 1px;
    }



    p,
    th,
    td {
        font-size: 12px;
    }

    small {
        font-size: 9px;
    }

    h1 {
        font-size: 96px;
    }

    h2 {
        font-size: 60px;
    }

    h3 {
        font-size: 30px;
    }

    h4 {
        font-size: 24px;
    }

    h5 {
        font-size: 18px;
    }

    h6 {
        font-size: 16px;
    }

    .color-green {
        color: #27ae60;
    }

    .color-red {
        color: #e74c3c;
    }

    .white-100 {
        color: #FFFFFF;
    }

    .white-95 {
        color: #F2F2F2;
    }

    .white-90 {
        color: #E0E0E0;
    }

    .white-80 {
        color: #CCCCCC;
    }

    .white-70 {
        color: #B3B3B3;
    }

    .white-60 {
        color: #999999;
    }

    .white-50 {
        color: #808080;
    }
</style>
