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

[monetize_me id="123"]

### Developer

```php
echo monetize_me_get_ad([
    'adcategory' => 'sidebar',
    'limit' => 1
]);
```

---

## 📝 Changelog

### 2.0.2
- Copy ad CPT across subsites
- Skip duplicate slugs
- Copy meta and taxonomy


---

## 📄 License

GPLv2 or later
