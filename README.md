# CMS

პროექტის ფუნციონირებაში მოსაყვანად მიჰყევით ინსტრუქციას


#### მოახდინეთ კომპოზერის ინსტალაცია


```bash
  composer install
```


- .env.example შიგთავისი გადაიტანეთ .env-ში და მოახდინეთ შესაბამისი მონაცმებიც გაწერა

- შექმენით ბაზა შესაბამისი სახელით რომელსაც გაუწერთ .env ფაილში

#### გაუშვით შემდეგი ბრძანება თეიბლების შესაქმნელად

```bash
  php artisan migrate
```

#### გაუშვით შემდეგი ბრძანება მონაცემთა ბაზაში ინფორმაციის შესატანად

```bash
  php artisan db:seed
```


- ბრძანების გაშვების შემდგომ admins თეიბლში ჩაემატება ადმინისტრატორი შესაბამისი მონაცემებით


## ადმინისტრატორის მონაცმები

| email                     | password                  |
| ------------------------- | ------------------------- |
| datokifshidze@gmail.com    | admin |



### მოახდინეთ პროექტის გაშვება შემდეგი ბრძანების საშვალებით

```bash
  php artisan serve
```


### დამხმარე სექცია

- თუ პროექტის შექმნისას წარმოიშვა გარკვეული სახის პრობელემები დაგეხამრებათ შემდეგი ბრძანებები

```bash
  php artisan key:generate
```
```bash
  php artisan config:cache
```

#### ადმინპანელის საბაზისო როუტები
```http
  GET  /admin
  GET  /admin/login
  POST /admin/login
  GET  /admin/dashboard
  GET  /admin/logout
