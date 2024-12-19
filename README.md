# Familjeköket WordPress Theme av William Falk

Ett skräddarsytt WordPress-tema för en receptblogg med fokus på familjevänliga recept. Temat är byggt med vite för snabbare och smidigare utveckling.

## 🚀 Kom igång

### Förutsättningar
- Docker och Docker Compose
- Node.js (v14 eller senare)
- npm
- WP Local för lokal utveckling (valfritt)

### Installation

1. Klona repot:
```bash
git clone https://github.com/wi-fa/wordpress-labb.git
```

2. Starta Docker:
```bash
docker-compose up -d
```

3. Cd'a till temat
```bash
cd wordpress/wp-content/themes/familjekoket/vite
```

4. Installera npm-paket:
```bash
npm install
```

5. Starta utvecklingsmiljön:
```bash
npm run watch
```

### Databashantering
Databasen ligger i `wp-content` för enkel backup.

## 🛠️ Utveckling

### Byggprocess
Temat använder Vite för snabb utveckling och optimerad byggprocess och typeScript används för strukturerad och typsäker javaScript-utveckling.

Utvecklingskommandon:
- `npm run watch` - Startar utvecklingsserver med HMR så man slipper ladda om vid varje save
- `npm run build` - Bygger för produktion

### Temafunktioner
- Custom post type för recept
- Taxonomier för receptkategorier och tags
- Responsiv design
- Custom widgets för sociala medier
- Fullskärmsmeny med senaste recept

## 🔌 Plugins

### Nödvändiga plugins

#### Advanced Custom Fields (ACF)
- Till anpassade fält i receptinlägg

#### Safe SVG
För säker hantering av SVG-uppladdningar

#### Cookiebot
- Används för: Cookie-hantering och GDPR-efterlevnad
- Kräver dock domänkonfiguration se nedan

#### All-in-One WP Migration
- Används för: DB migrering och backup
- Jag installerade detta för att kunna testa cookiebanner ifrån cookiebot. Detta krävde dock att webbappen har en egen domän. Jag prövade detta med WP Local. Vill man testa så finns det info om det nedan

#### WP Mail SMTP
- Status: Delvis konfigurerat
- Planerat för: E-posthantering från kontaktformulär

### Lokal utveckling med WP Local

För att testa Cookiebot lokalt:

1. Installera WP Local
2. Skapa en ny site med domänen `familjekoket.local`
3. Konfigurera hosts-filen:
   ```
   127.0.0.1 familjekoket.local
   ```
4. Aktivera SSL i WP Local
5. Konfigurera Cookiebot med den lokala domänen

## 🎨 Tema-struktur

```
familjekoket-theme/
├── dist/                    # Kompilerade filer
│   ├── css/                # Kompilerad CSS
│   └── js/                 # Kompilerad JavaScript från TypeScript
├── template-parts/          # Återanvändbara malldelar
│   ├── components/         # Mindre, återanvändbara komponenter
│   ├── content/           # Innehållsrelaterade mallar
│   └── navigation/        # Navigationsrelaterade mallar
├── vite/                    # Vite utvecklingsmiljö
│   ├── node_modules/      # Node.js paket
│   ├── src/              # Källkodsfiler
│   │   ├── scss/        # SCSS stilmallar
│   │   └── ts/          # TypeScript källkod
│   ├── package.json     # Node.js pakethantering
│   ├── tsconfig.json    # TypeScript konfiguration
│   └── vite.config.js   # Vite konfiguration
├── page-templates/          # Anpassade sidmallar
├── 404.php                 # Felsida
├── archive.php             # Arkivsida för inlägg
├── author.php              # Författarsida
├── footer.php              # Sidfot
├── front-page.php          # Startsida
├── functions.php           # Temats funktioner
├── header.php              # Sidhuvud
├── index.php               # Huvudmall
├── search.php              # Söksida
├── single-recipe.php       # Mall för enskilda recept
└── style.css               # Temats huvudstilmall
```

## 📝 Utvecklingsanteckningar

### URL-struktur för recept
- `/recept` - Alla recept
- `/recept/kategori/[kategorinamn]` - Receptkategori
- `/recept/tag/[taggnamn]` - Recepttagg
- `/recept/[receptnamn]` - Enskilt recept