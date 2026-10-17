<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Catalogue d'exemple : à remplacer par vos vraies formations depuis l'espace admin.
 */
class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        Setting::put(Setting::DEFAULTS);

        $categories = [
            'btp' => ['BTP & Architecture', '#c46a12'],
            'info' => ['Informatique & Bureautique', '#2d6cdf'],
            'design' => ['Graphisme & Impression', '#b8337a'],
            'market' => ['Marketing digital', '#7a4fd6'],
            'business' => ['Business & Gestion', '#0b6e55'],
            'dev' => ['Programmation & Web', '#13808f'],
            'video' => ['Vidéo & Photo', '#c2403a'],
            'lang' => ['Langues', '#5f7d1a'],
        ];
        $ids = [];
        $pos = 0;
        foreach ($categories as $key => [$name, $color]) {
            $ids[$key] = Category::updateOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'color' => $color, 'position' => $pos++])->id;
        }

        $courses = [
            ['BTP-01', 'btp', 'AutoCAD 2D de A à Z', 'Débutant', 12, 48, 75000, 'Dessiner des plans de bâtiment propres et cotés, prêts à imprimer.', ['Interface et commandes de base', "Dessin d'un plan de villa", 'Cotation, textes et calques', 'Mise en page et impression PDF']],
            ['BTP-02', 'btp', 'Modélisation 3D et rendus (SketchUp + Twinmotion)', 'Intermédiaire', 10, 36, 100000, 'Passer du plan 2D à une maquette 3D et des images réalistes pour le client.', ['Modéliser une villa R+1', 'Matériaux et textures', 'Rendus et vidéo de visite', 'Présenter au client']],
            ['BTP-03', 'btp', 'Métré et devis bâtiment', 'Débutant', 6, 22, 60000, 'Calculer les quantités et sortir un devis chiffré poste par poste.', ['Lire un plan pour le métré', 'Terrassement et fondations', 'Béton armé et maçonnerie', 'Modèle de devis Excel']],
            ['INF-01', 'info', 'Excel du débutant au pro', 'Tous niveaux', 14, 60, 60000, 'Tableaux, formules, tableaux croisés et tableaux de bord pour le travail.', ['Saisie et mise en forme', 'Formules essentielles (SOMME, SI, RECHERCHEX)', 'Tableaux croisés dynamiques', 'Tableau de bord de ventes']],
            ['INF-02', 'info', 'Word et PowerPoint professionnels', 'Débutant', 8, 32, 45000, 'Rédiger des documents et des présentations qui font sérieux.', ['Mise en page et styles', 'CV, lettres et rapports', 'Présentations efficaces', 'Export PDF et impression']],
            ['DES-01', 'design', 'Canva pour les pros', 'Débutant', 6, 28, 40000, 'Affiches, flyers, posts réseaux sociaux et cartes de visite en quelques minutes.', ['Prise en main', "Identité visuelle d'une marque", 'Supports imprimables', 'Posts et stories']],
            ['DES-02', 'design', 'Photoshop et Illustrator', 'Intermédiaire', 16, 64, 90000, "Retouche photo, logos et maquettes prêtes pour l'imprimerie.", ['Retouche et détourage', 'Création de logo vectoriel', "Préparer un fichier pour l'impression", 'Mockups et présentation']],
            ['MKT-01', 'market', 'Vendre sur Facebook et Instagram', 'Débutant', 8, 30, 60000, 'Créer une page qui vend et lancer ses premières publicités.', ['Page et contenu', 'Publicités Meta pas à pas', 'Ciblage et budget', 'Mesurer ses ventes']],
            ['MKT-02', 'market', 'WhatsApp Business pour vendre', 'Débutant', 4, 16, 35000, 'Catalogue, réponses rapides et statuts qui transforment en clients.', ['Configurer WhatsApp Business', 'Catalogue produits', 'Messages automatiques', 'Relancer ses clients']],
            ['BUS-01', 'business', 'Comptabilité pour petites entreprises', 'Débutant', 10, 38, 70000, 'Tenir sa caisse, ses factures et ses comptes sans être comptable.', ['Recettes et dépenses', 'Factures et reçus', 'Stock et marge', 'Bilan simple']],
            ['DEV-01', 'dev', 'Créer un site web sans coder', 'Débutant', 8, 30, 70000, 'Un site professionnel pour son activité avec WordPress.', ['Nom de domaine et hébergement', 'Installer WordPress', 'Pages et design', 'Formulaire et WhatsApp']],
            ['DEV-02', 'dev', "Utiliser l'IA au travail", 'Tous niveaux', 4, 16, 40000, "Gagner du temps avec les assistants IA : rédaction, Excel, images.", ['Bien poser ses questions', 'Rédiger et résumer', 'IA et Excel', 'Créer des visuels']],
            ['VID-01', 'video', 'Montage vidéo avec CapCut', 'Débutant', 6, 24, 45000, 'Monter des vidéos pro sur téléphone et PC.', ['Couper et assembler', 'Textes et sous-titres', 'Musique et effets', 'Exporter pour les réseaux']],
            ['LAN-01', 'lang', 'Anglais professionnel', 'Débutant', 20, 60, 80000, 'Parler, écrire des e-mails et passer un entretien en anglais.', ['Bases de la conversation', 'E-mails et téléphone', 'Vocabulaire du travail', 'Préparer un entretien']],
        ];

        foreach ($courses as [$code, $cat, $title, $level, $hours, $lessons, $price, $desc, $program]) {
            Course::updateOrCreate(['code' => $code], [
                'category_id' => $ids[$cat],
                'slug' => Str::slug($code.' '.$title),
                'title' => $title,
                'description' => $desc,
                'level' => $level,
                'hours' => $hours,
                'lessons' => $lessons,
                'price' => $price,
                'program' => $program,
                'is_published' => true,
            ]);
        }
    }
}
