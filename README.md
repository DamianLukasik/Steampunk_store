# Steampunk_store
Projekt w symfony, gdzie można od razu dodać produkty do zamówienia, wyświetlić listę zamówień oraz wyświetlić szczegółowe informacje o produktach. Produkty i sklep są fikcyjne. Projekt ma na celu pokazanie funkcjonalności.

## Instalacja

1. **Pobierz projekt**

Sklonuj repozytorium na swój lokalny komputer:

```bash
git clone https://github.com/DamianLukasik/Steampunk_store.git
```

2. **Przejdź do katalogu projektu**

```bash
cd Steampunk_store
```

3. **Zainstaluj zależności**

Użyj Composer do zainstalowania niezbędnych zależności:

```bash
composer install
```

4. **Migracje**

W terminalu można wykonać polecenie dodającą tylko strukturę tabel:

```bash
php bin/console doctrine:migrations:migrate
```

Lub (dla ułatwienia pracy) można wykonać polecenie dodającą strukturę tabel wraz z przykładowymi danymi:

```bash
php migrations/AddData.php add
```

W przypadku wpisania:

```bash
php migrations/AddData.php
```

pojawi się lista dostępnych opcji, gdzie do wyboru jest możliwość dodawania oraz usuwania danych.

5. **Uruchom lokalny serwer**

```bash
php -S 127.0.0.1:8000 -t public
```

6. **Otwórz przeglądarkę**

Otwórz przeglądarkę i wejdź na stronę: http://127.0.0.1:8000

## Dostępne funkcjonalności

1. **Lista produktów**

na stronie `\` można podejrzeć listę produktów. Przycisk 'Przełącz widok na masowe dodawanie produktów' umożliwia przełączenie widoku na tryb masowego dodawania produktów polegające na ustawieniu liczby danego produktu przy użyciu przycisków + i -, aby przy pomocy przycisku 'Zamów' stworzyć zamówienie. Tryb 'Przełącz widok na pojedyncze dodawanie produktów' umożliwia stworzenie zamówienia z jednym produktem przy pomocy przycisku 'Zamów' pod danym produktem.

2. **Karta produktu**

Kliknięcie na obrazek produktu przekierowuje użytkownika na `product/{id}`, gdzie można podejrzeć zdjęcie produktu (wygenerowane przez MidJourney - to nie jest prawdziwy produkt), nazwę, cenę, kategorie, producenta, dostępność (aby móc zamówić), funkcje oraz wykorzystane materiały. Przy każdym materiasle są ikonki oznaczjące czy dany materiał jest ognioodporny i/lub czy przewodzi prąd elektryczny. Dany produkt można dodać do zamówienia poprzez naciśnięcie przycisku 'Zamów'.

3. **Karta produktu**

Kliknięcie na pozycje w panelu nawigacyjnym 'Zamówienia' przekierowuje użytkownika na `orders`, gdzie można podejrzeć listę dokonanych zamówień. Wyświetlane są informacje na temat daty dokonanego zamówienia, sumy częściowej, vat, sumy łącznej, liczby produktów oraz czy dane zamówienia zostało opłacone i/lub dostarczone.

## Użyto

1. **Zdjęcia fikcyjnych produktów**

Zdjęcia zostały wygenerowane przy użyciu midjourney (https://www.midjourney.com/explore)

2. **Wykorzystano:**
- jquery
- bootstrap
- font awesome
- twig

W projekcie można dokonać migracji dodającej strukturę tabel oraz wykonać skrypt dodający przykładowe dane do tabel.
