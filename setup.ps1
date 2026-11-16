# Jalankan dari folder projek:  powershell -ExecutionPolicy Bypass -File setup.ps1
$ErrorActionPreference = 'Stop'
if (-not (Test-Path .env)) { Copy-Item .env.example .env }
$c = Get-Content .env -Raw
$set = [ordered]@{
  APP_NAME='BookStore'; APP_LOCALE='id'; DB_CONNECTION='mysql'; DB_HOST='127.0.0.1'; DB_PORT='3306';
  DB_DATABASE='bookstore'; DB_USERNAME='root'; DB_PASSWORD='';
  SESSION_DRIVER='file'; CACHE_STORE='file'; QUEUE_CONNECTION='sync';
  MIDTRANS_SERVER_KEY=''; MIDTRANS_CLIENT_KEY=''
}
foreach ($k in $set.Keys) {
  $line = "$k=" + $set[$k]
  if ($k -like 'MIDTRANS*' -and $c -match "(?m)^$k=.+$") { continue }   # jangan timpa key yang sudah diisi
  if ($c -match "(?m)^#?\s*$k=.*$") { $c = [regex]::Replace($c, "(?m)^#?\s*$k=.*$", $line) }
  else { $c = $c.TrimEnd() + "`n$line`n" }
}
[IO.File]::WriteAllText((Join-Path (Get-Location) '.env'), $c)
Write-Host '.env diperbarui.'
php artisan key:generate --force
php artisan config:clear
php artisan migrate:fresh --seed --force
php artisan storage:link
Write-Host 'Selesai. Jalankan: php artisan serve'
