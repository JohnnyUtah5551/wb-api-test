<?php
// Данные для подключения к API
$apiKey = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';
$baseUrl = 'http://109.73.206.144:6969/api';

// Функция для загрузки данных
function fetchData($endpoint, $apiKey, $dateFrom = '2024-01-01') {
    $url = "{$baseUrl}/{$endpoint}?dateFrom={$dateFrom}&key={$apiKey}&limit=500";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode == 200) {
        return json_decode($response, true);
    }
    return null;
}

// Загружаем данные
$sales = fetchData('sales', $apiKey);
$orders = fetchData('orders', $apiKey);
$stocks = fetchData('stocks', $apiKey);
$incomes = fetchData('incomes', $apiKey);

// Показываем результат
echo "<h1>Загрузка данных из API</h1>";
echo "<h2>Результаты:</h2>";
echo "<ul>";
echo "<li>Продажи: " . count($sales ?? []) . " записей</li>";
echo "<li>Заказы: " . count($orders ?? []) . " записей</li>";
echo "<li>Склады: " . count($stocks ?? []) . " записей</li>";
echo "<li>Доходы: " . count($incomes ?? []) . " записей</li>";
echo "</ul>";

// Если хотим сохранить в файл
file_put_contents('sales.json', json_encode($sales, JSON_PRETTY_PRINT));
file_put_contents('orders.json', json_encode($orders, JSON_PRETTY_PRINT));
file_put_contents('stocks.json', json_encode($stocks, JSON_PRETTY_PRINT));
file_put_contents('incomes.json', json_encode($incomes, JSON_PRETTY_PRINT));

echo "<p>Данные сохранены в JSON файлы!</p>";
?>
