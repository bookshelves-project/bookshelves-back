<?php

return [
    'users' => [
        'name' => 'Utilisateur|Utilisateurs',
        'attributes' => [
            'role' => 'Rôle',
            'last_login_at' => 'Dernièrement connecté le',
        ],
    ],
    'pages' => [
        'name' => 'Page|Pages',
        'attributes' => [
            'template' => 'Nom du modèle de page utilisé',
            'slides' => 'Liste des atouts',
        ],
    ],
    'blocks' => [
        'name' => 'Bloc|Blocs',
        'attributes' => [
            'section' => 'Zone de placement',
            'page_ids' => 'Pages liées',
            'post_ids' => 'Articles liés',
            'post_category_ids' => "Catégories d'article liées",
            'page_residence_ids' => 'Pages résidence liées',
            'Separate each urls by a new line' => 'Séparer chaque URL par un retour à la ligne',
            'system_urls' => 'URLs système (ex: /actualites)',
        ],
    ],
    'posts' => [
        'name' => 'Article|Articles',
        'attributes' => [
            'universe' => 'Univers',
            'category' => 'Catégorie',
            'status' => 'Statut',
            'pin' => 'Epinglé',
            'promote' => 'Mis en avant',
            'user' => 'Auteur',
        ],
    ],
    'testimonies' => [
        'name' => 'Témoignage|Témoignages',
        'attributes' => [],
    ],
    'services' => [
        'name' => 'Services',
        'attributes' => [
            'text' => 'Texte',
        ],
    ],
    'residences' => [
        'name' => 'Residences',
        'attributes' => [
            'id_mdm' => 'ID MDM',
            'id_grimmo' => 'ID GRIMMO',
            'id_sci' => 'ID SCI',
            'id_dwh' => 'ID DWH',
            'status' => 'Statut',
            'city' => 'Ville',
            'call_price' => "Prix d'appel",
            'remaining_lots' => 'Lots restants',
        ],
    ],
    'page-residences' => [
        'name' => 'Pages Résidence',
        'attributes' => [
            'id_mdm' => 'ID MDM',
            'leadership_identity' => 'Identité du directeur / de la directrice',
            'leadership_text' => 'Mot de la direction',
            'leadership_role' => 'Intitulé du poste',
            'team_text' => "Description d'équipe",
            'assets_list' => 'Liste des atouts',
            'tab_gallery' => 'Galerie photo',
            'tab_assets' => 'Atouts',
            'tab_city' => 'Ville / Carte',
            'tab_service' => 'Service',
            'tab_team' => 'Equipe',
            'tab_menu' => 'Menu',
            'tab_apartment' => 'Appartements',
            'tab_opinion' => 'Avis',
            'empty' => 'Laisser vide pour ne pas afficher',
            'lunch' => 'Menu du midi',
            'diner' => 'Menu du soir',
            'services' => 'Services',
            'opinions_legal_text' => 'Texte juridique des avis',
            'apartment_t1' => 'Appartement T1',
            'apartment_t2' => 'Appartement T2',
            'apartment_t3' => 'Appartement T3',
            'civiliz_id' => 'ID Civiliz',
            'partoo_id' => 'ID Partoo',
        ],
    ],
    'residence-lots' => [
        'name' => 'Lots disponibles',
        'attributes' => [
            'id_mdm' => 'Résidence liée',
            'housing_type' => 'Type de logement',
            'date_in' => "Date d'entrée",
            'date_out' => 'Date de sortie',
            'base_price' => 'Prix de base',
            'additional_person_price' => 'Prix supplémentaire par pers.',
            'old_person_option_price' => 'Prix option + 65 ans',
        ],
    ],
    'animations' => [
        'name' => 'Animations',
        'attributes' => [
            'id_mdm' => 'Résidence',
            'text' => 'Texte',
            'start_date' => 'Date de début',
        ],
    ],
    'page-residence-projects' => [
        'name' => 'Pages Programme',
        'attributes' => [
            'id_mdm' => 'ID MDM',
            'law' => 'Loi',
            'delivery_date' => 'Date de livraison',
            'tab_marketing' => 'Marketing',
            'tab_gallery' => 'Galerie photo',
            'tab_plan' => 'Avantages du dispositif',
            'tab_lot' => 'Lots',
            'tab_contact' => 'Contact',
            'tab_map' => 'Carte',
            'tab_invest' => 'Investissement',
            'Marketing banner insert' => 'Encarts marketing du bandeau',
            'marketing_list' => 'Encarts marketing du bandeau',
            'empty' => 'Laisser vide pour ne pas afficher',
            'Separate each element by a new line' => 'Séparer chaque élément par un retour à la ligne',
            'legal' => 'Mention située en dessous du bloc',
            'call_price' => "Prix d'appel (€)",
            'caption' => 'Légende',
            'contact_text_1' => 'Phrase 1',
            'contact_text_2' => 'Phrase 2',
        ],
    ],
    'residence-projects' => [
        'name' => 'Programmes',
        'attributes' => [
            'id_mdm' => 'ID MDM',
            'id_grimmo' => 'ID GRIMMO',
            'code_maturity' => 'Code maturité',
            'city' => 'Ville',
            'call_price' => "Prix d'appel",
            'remaining_lots' => 'Lots restants',
            'law' => 'Loi',
            'delivery_date' => 'Date de livraison',
            'construction_start_date' => 'Date début construction',
        ],
    ],
    'faq-categories' => [
        'name' => 'FAQ - Catégories',
        'attibutes' => [],
    ],
    'faq-questions' => [
        'name' => 'FAQ - Questions',
        'attibutes' => [],
    ],
];