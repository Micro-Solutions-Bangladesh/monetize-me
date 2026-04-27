# Monetize Me

Monetize Me is a flexible WordPress plugin to manage and display advertisements across single-site and multisite setups.

---

## 🚀 Features

- Custom Post Type: ad  
- Taxonomies: adcategory, adsponsor  
- Shortcode support  
- Multisite Network Admin tools  
- Copy ads across subsites (skip duplicate slug)  

---

## ⚙️ Installation

1. Upload to `/wp-content/plugins/`
2. Activate plugin (network activate for multisite)
3. Access settings in Network Admin

---

## 🧩 Usage

### Shortcode

#### The main shortcode is:

```[mmps]```

##### Supported attributes:

- *id*: 
  Display one specific ad by post slug.

- *adcategory*: 
  Either a single slug of an ad Category or CSV IDs of Ad Category.

- *adsponsor*: 
  One or more Ad Sponsor term IDs separated by commas.

- *limit*: 
  Number of ads to display. Default: 1

- *wrapper*: 
  Wrap each ad in <div class="ad-wrapper">. Accepts 1 or 0. Default: 1

- *class*: 
  Extra alignment or styling class for the outer wrapper.

= Shortcode examples =

#### Display a specific ad by ad slug:

```[mmps id="homepage-leaderboard"]```

#### Display one random ad from category ID 12:

```[mmps adcategory="12"]```

#### Display one random ad from the ad category with the slug "in-article-ad":

```[mmps adcategory="in-article-ad"]```

#### Display two random ads from category ID 12:

```[mmps adcategory="12" limit="2"]```

#### Display ads from category 12 and sponsor 3:

```[mmps adcategory="12" adsponsor="3"]```

#### Display an ad without wrapper markup:

```[mmps id="sidebar-ad-1" wrapper="0"]```

### Developer

```php
echo monetize_me_get_ad([
    'adcategory' => 'sidebar',
    'limit' => 1
]);
```

---

## 📄 License

GPLv2 or later
