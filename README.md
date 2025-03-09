# Paravent (Laravel Implementation)

Ce projet est une implémentation en **Laravel** de l'exercice **"Paravent"**.  
L'application permet de calculer la surface protégée par des montagnes face à un vent venant de l'ouest.

---

## 📌 Prérequis  

Avant d’installer et d’utiliser ce projet, assurez-vous que votre environnement respecte les versions minimales requises :  
- **Laravel** : 12.1.1
- **PHP** : 8.4.2  
- **Composer** : 2.8.4  

Vous pouvez vérifier les versions installées avec :  
```bash
php -v       # Vérifier la version de PHP
composer -V  # Vérifier la version de Composer
php artisan --version  # Vérifier la version de Laravel
```

## 📌 Installation

Ce guide explique comment configurer le projet et enregistrer la commande Artisan.

1. **Cloner le dépôt et entrer dans le dossier du projet**
   ```bash
   git clone https://github.com/Ohabiballah/paravent.git
   cd paravent
   ```

2. **Installer les dépendances avec Composer**
   ```bash
   composer install
   ```

3. **Configurer l’environnement**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Lancer le serveur de développement**
   ```bash
   php artisan serve
   ```

## 📌 Signature de la commande

La commande Artisan intégrée permet d’exécuter l’algorithme directement depuis le terminal.

**Syntaxe :**
```bash
php artisan app:calculate-protected-area {width} {altitudes...}
```

### 📌 Exemple d'exécution :
```bash
php artisan app:calculate-protected-area 10 30 27 17 42 29 12 14 41 42 42
```

### 📌 Sortie attendue :
```nginx
Surface protégée : 6
```

## 📌 Gestion des erreurs

Le programme intègre une gestion robuste des erreurs pour éviter les comportements inattendus.

| Erreur | Cause | Message d'erreur |
|--------|-------|------------------|
| **Aucune entrée fournie** | Aucun argument passé | Erreur : Vous devez spécifier la largeur du continent et au moins une altitude. |
| **Valeurs non numériques** | Saisie contenant des caractères invalides | Erreur : Toutes les altitudes doivent être des nombres. |
| **Entrée trop grande** | Plus de 100 000 valeurs passées | Erreur : La largeur du continent {$width} doit être comprise entre 1 et 100 000. |
| **Largeur non valide** | Largeur non numérique ou hors limites | Erreur : La largeur du continent doit être un entier compris entre 1 et 100 000. |
| **Nombre d'altitudes incorrect** | Nombre d'altitudes différent de la largeur spécifiée | Erreur : Le nombre d'altitudes doit être égal à la largeur du continent ({$width}). |
| **Altitude hors limites** | Valeur d'altitude inférieure à 0 ou supérieure à 100 000 | Erreur : La hauteur {$altitude} doit être comprise entre 0 et 100 000. |
| **Exception interne** | Problème inattendu lors du traitement | Erreur : Une erreur s'est produite : {$message}. |

### 📌 Exemple d'erreur

```bash
php artisan app:calculate-protected-area abc 27 17
```

**Sortie :**
```yaml
Erreur : La largeur du continent doit être un entier.
```

## 📌 Explication de l'algorithme

L'algorithme utilisé dans ce projet permet de calculer la surface protégée en analysant les altitudes des montagnes.

### 📝 Principe de l'algorithme
- On parcourt la liste des altitudes de gauche à droite (vent venant de l'ouest).
- On garde en mémoire la hauteur maximale rencontrée jusqu'à présent.
- Si une montagne est plus haute que la hauteur maximale, elle devient la nouvelle référence.
- Si une montagne est plus basse, elle est considérée comme protégée.

### 📂 Implémentation en PHP

```php
namespace App\Services;

class MountainProtectionService
{
    /**
     * Calcule la surface protégée par les montagnes.
     *
     * @param array $altitudes
     * @return int
     */
    public function calculateProtectedArea(array $altitudes): int
    {
        $maxHeight = 0; // Hauteur maximale rencontrée
        $protectedArea = 0;

        foreach ($altitudes as $height) {
            if ($height >= $maxHeight) {
                $maxHeight = $height; // Si la montagne est plus haute, on met à jour la hauteur maximale
            } else {
                $protectedArea++; // Si la montagne est inférieure, elle est protégée
            }
        }

        return $protectedArea;
    }
}
```

### 📝 Complexité de l'algorithme
L'algorithme fonctionne en **O(n)**, où **n** est le nombre d'altitudes. Il est donc très efficace et peut traiter de grandes entrées rapidement.

---

🚀 **Ce projet est conçu pour être rapide, efficace et facile à utiliser !**

💻 **N’hésitez pas à contribuer et à proposer des améliorations !**

