<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $novel->title }} - Chapter {{ $chapter->chapter_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #1a1a1a;
            line-height: 1.8;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #7c3aed;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .novel-title {
            font-size: 22px;
            font-weight: bold;
            color: #7c3aed;
            margin-bottom: 5px;
        }
        .chapter-title {
            font-size: 16px;
            color: #555;
        }
        .content {
            font-size: 14px;
            text-align: justify;
            word-wrap: break-word;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="novel-title">{{ $novel->title }}</div>
    <div class="chapter-title">Chapter {{ $chapter->chapter_number }}: {{ $chapter->title }}</div>
</div>

<div class="content">
    {!! nl2br(e($chapter->content)) !!}
</div>

<div class="footer">
    Diunduh dari NovelKu — Platform Novel Online • Buatan Sebastian Botu
</div>

</body>
</html>
