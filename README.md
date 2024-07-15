# Online Kviz 

## Opis

Ova aplikacija je veb platforma za igranje online kvizova. Korisnici mogu igrati kvizove u privatnim i javnim sobama. Administratori imaju mogućnost kreiranja sopstvenih soba. Poeni se dodeljuju na osnovu tačnosti i brzine odgovora. Uz pomoć soketa omogućen je uvid u broj korisnika koji su već odgovorili na pitanje i onih koji još uvek razmišljaju.

## Tehnologije

- **Backend:** Laravel
- **Baza podataka:** MySQL
- **Frontend:** React (pogledajte zaseban `README.md` u frontend repozitorijumu)
- **Alati:** phpMyAdmin

## Setup za Backend

1. **Kloniranje repozitorijuma:**

   ```bash
   git clone https://github.com/elab-development/internet-tehnologije-projekat-onlinekviz_2020_0168.git
   cd internet-tehnologije-projekat-onlinekviz_2020_0168
   ```

2. **Navigacija do backend foldera:**

   ```bash
   cd backend
   ```

3. **Instalacija zavisnosti:**

   Uverite se da imate instaliran Composer. Zatim pokrenite:

   ```bash
   composer install
   ```

4. **Podešavanje `.env` fajla:**

   Kopirajte `.env.example` fajl u `.env`:

   ```bash
   cp .env.example .env
   ```

   Konfigurišite `.env` fajl sa odgovarajućim podešavanjima baze podataka i drugih parametara.

5. **Generisanje aplikacionog ključa:**

   ```bash
   php artisan key:generate
   ```

6. **Migracija i sejanje baze podataka:**

   Uverite se da vaša MySQL baza podataka radi, zatim pokrenite:

   ```bash
   php artisan migrate --seed
   ```

## Pokretanje projekta

Pokrenite lokalni razvojni server:

```bash
php artisan serve
```

Aplikacija će biti dostupna na `http://localhost:8000`.

## Setup za Frontend


1. **Navigacija do frontend foldera:**

   ```bash
   cd projekat_frontend
   ```

2. **Instalacija zavisnosti:**

   Uverite se da imate instaliran Node.js. Zatim pokrenite:

   ```bash
   npm install
   ```
3. **Kreiranje .env fajla:**

   Kreirajte .env fajl u projekat_frontend direktorijumu kako biste sačuvali promenljive okruženja za React aplikaciju.
   Primer sadržaja .env fajla:

      ```bash
   REACT_APP_API_URL=http://localhost:8000/api
   REACT_APP_SOCKET_URL=http://localhost:6001
      ```   
      
4. **Pokretanje React razvojnog servera:**

   ```bash
   npm start
   ```


## Funkcionalnosti

1. **Registracija:**
   - Korisnici mogu da kreiraju nalog unosom svog imena, mejl adrese i lozinke.
   
2. **Prijava:**
   - Korisnici mogu da se prijave na sistem unosom mejl adrese i lozinke.
   
3. **Promena zaboravljene lozinke:**
   - Korisnici mogu da resetuju svoju lozinku putem mejla.

4. **Kreiranje kviza:**
   - Administratori mogu da kreiraju nove kvizove sa pitanjima i odgovorima.
   
5. **Igranje kviza:**
   - Korisnici mogu da učestvuju u kvizovima, odgovaraju na pitanja i dobijaju poene na osnovu tačnosti i brzine.

## API Dokumentacija

API dokumentacija se može naći u PDF dokumentu "ITEH dokumentacija.pdf" ili u sekciji `api.php` Laravel aplikacije.
