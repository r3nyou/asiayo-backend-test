# 範例啟動
```shell
cp .env.example .env
docker-compose build && docker-compose up -d
docker exec asiayo-backend-test-api-1 composer install
```

# 測試方式
執行 unit test、feature test
```shell
docker exec asiayo-backend-test-api-1 php artisan test
```

測試案例在 `tests/Unit`、`test/Feature`，測試案例包含
1. 指定匯率資料
2. 輸入整數可轉換
3. 輸入浮點數可轉換
4. 輸入浮點數小數點超過 2 位可轉換
5. 輸入金額會四捨五入到小數點後 2 位
6. 輸入金額為 0 轉換金額為 0
7. 輸入負數不可轉換
8. 輸入格式錯誤
9. 輸入不支援的幣別
10. 未設定轉換前、後幣別
11. 轉換後格式
12. API 請求正常

轉換前後範例
```
# forex rate: 1 USD to JPT 111.801
USD         JPY
0           0.00
0.004       0.00
0.005       1.12
0.01        1.12
0.1         11.18
1           111.80
1.00        111.80
10000       1,118,010.00
```

API curl
```shell
curl --location --request GET 'http://localhost/api/currency-converter?amount=123.45&from=USD&to=JPY' \
--header 'Accept: application/json'
```

# 說明
匯率轉換的類別在 `app/Crrency`

為了避免傳遞的參數過多，並提供更易讀的程式碼，實作了 Fluent Interface

輸入的金額小數點後 2 位、匯率小數點後 5 位，需要較高精度的計算，因此 Currency 類別使用 [BC Math](https://www.php.net/manual/en/book.bc.php) 計算

BC MATH 提供任意大小、精度的計算，最多為 0x7FFFFFFF，[參考](https://www.php.net/manual/en/intro.bc.php)

自訂 CurrencyException 處理例外的回傳格式，並在 Handler 註冊，省去 try...catch...
