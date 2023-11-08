// chart.js

Morris.Donut({
    element: 'demo-morris-donut',
    data: dataNilai, // Anda dapat memasukkan data langsung tanpa perlu menggunakan json_encode
    colors: [
        '#ec407a',
        '#03a9f4',
        '#d8dfe2',
        // Tambahkan warna sesuai dengan kebutuhan Anda.
    ],
    resize: true
});
