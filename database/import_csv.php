<?php

$csvPath = 'C:\\Users\\ferry\\.gemini\\antigravity-ide\\brain\\515087d7-7c9a-4fb4-babc-2addc7a43907\\.system_generated\\steps\\171\\content.md';
$outPath = __DIR__ . '/students_spreadsheet.json';

$lines = file($csvPath);
$csvLines = [];
$start = false;

foreach ($lines as $line) {
    if (str_contains($line, 'Timestamp,NAMA LENGKAP')) {
        $start = true;
    }
    if ($start) {
        $csvLines[] = $line;
    }
}

$csvString = implode('', $csvLines);
$rows = array_map('str_getcsv', explode("\n", $csvString));
$header = array_shift($rows);

$students = [];
$idx = 1;

foreach ($rows as $row) {
    if (!$row || count($row) < 3) continue;
    $data = [];
    foreach ($header as $hIdx => $hName) {
        $data[trim($hName)] = $row[$hIdx] ?? '';
    }
    
    $name = trim($data['NAMA LENGKAP'] ?? '');
    if (!$name) continue;

    $code = sprintf('ASSA-6%03d', $idx);
    $progRaw = strtoupper(trim($data['PROGRAM'] ?? ''));
    if (str_contains($progRaw, 'SEMI')) {
        $prog = 'SEMI PRIVATE';
    } elseif (str_contains($progRaw, 'REGULER') || str_contains($progRaw, 'KELOMPOK')) {
        $prog = 'GRUP';
    } elseif (str_contains($progRaw, 'PRIVATE') || str_contains($progRaw, '1 PELATIH')) {
        $prog = 'PRIVATE';
    } elseif (str_contains($progRaw, 'TRIAL')) {
        $prog = 'TRIAL';
    } else {
        $prog = $progRaw ?: 'GRUP';
    }

    $levelNum = ($idx % 3) + 1;
    $progress = 20 + (($idx * 7) % 75);

    $students[] = (object)[
        'id' => $idx,
        'code' => $code,
        'name' => mb_strtoupper($name, 'UTF-8'),
        'age' => trim($data['UMUR'] ?? ''),
        'parent_name' => trim($data['NAMA ORANG TUA'] ?? ''),
        'phone' => trim($data['NO HP'] ?? ''),
        'address' => trim($data['ALAMAT'] ?? ''),
        'program' => $prog,
        'nominal' => trim($data['NOMINAL PEMBAYARAN'] ?? ''),
        'location' => trim($data['KOLAM BERENANG'] ?? ''),
        'schedule' => trim($data['HARI LATIHAN TETAP'] ?? ''),
        'level' => 'LEVEL ' . $levelNum,
        'progress' => $progress,
        'status' => 'Active'
    ];
    $idx++;
}

file_put_contents($outPath, json_encode($students, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "Successfully converted " . count($students) . " students to JSON!\n";
