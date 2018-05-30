<?php
$ch = curl_init();

$qry_str = "password=ppppp&user=11111"; //web api heslo
curl_setopt($ch, CURLOPT_URL, 'https://www.odorik.cz/api/v1/speed_dials.json');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $qry_str);

$content = trim(curl_exec($ch));
curl_close($ch);

$json = json_decode($content,true);

// seřadit pole podle jména
usort($json, function ($item1, $item2) {
        return $item1['name'] <=> $item2['name'];
});

Header('Content-type: text/xml');

echo "<directory>".PHP_EOL;

foreach ($json as $entry) {
    echo "<entry>";
    echo "<extension>";
    echo str_replace("00420","",$entry['number']);
    echo "</extension>";
    echo "<name>";
    echo $entry['name'];
    echo "</name>";
    if (strpos( $entry['number'] ,'*') === false ) {
        echo "<presence>0</presence>";
    } else {
        echo "<presence>1/presence>";
    };
    echo "</entry>".PHP_EOL;
}

echo "</directory>";
?>
