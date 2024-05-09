<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アップロード完了</title>
</head>
<body>
    <h1>ファイルのアップロードが完了しました</h1>
    <p>アップロードされたファイル名: {{ $filename }}</p>
    <a href="/storage/{{ $filename }}">{{ $filename }}</a>
    <button onclick="downloadFile()">ファイルをダウンロード</button>

    <!-- ダウンロード処理を行うJavaScript関数 -->
    <script>
        function downloadFile() {
            // ダウンロード処理を行うためのリクエストを送信
            window.location.href = "/download";
        }
    </script>

</body>
</html>