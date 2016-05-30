-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `dig`;
CREATE DATABASE `dig` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `dig`;

DROP TABLE IF EXISTS `aai_service`;
CREATE TABLE `aai_service` (
  `user_id` int(10) unsigned NOT NULL,
  `service_id` int(10) unsigned NOT NULL,
  KEY `aai_service_user_id_foreign` (`user_id`),
  KEY `aai_service_service_id_foreign` (`service_id`),
  CONSTRAINT `aai_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  CONSTRAINT `aai_service_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `aai_service` (`user_id`, `service_id`) VALUES
(5,	1),
(4,	1),
(2,	2),
(5,	2),
(3,	3),
(1,	3),
(4,	3),
(3,	4),
(3,	7),
(1,	7),
(2,	7),
(3,	8),
(4,	8),
(1,	8),
(2,	8),
(2,	9),
(3,	10),
(2,	10);

DROP TABLE IF EXISTS `ars_service`;
CREATE TABLE `ars_service` (
  `user_id` int(10) unsigned NOT NULL,
  `service_id` int(10) unsigned NOT NULL,
  KEY `ars_service_user_id_foreign` (`user_id`),
  KEY `ars_service_service_id_foreign` (`service_id`),
  CONSTRAINT `ars_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ars_service_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `ars_service` (`user_id`, `service_id`) VALUES
(2,	1),
(3,	1),
(3,	2),
(1,	2),
(5,	3),
(5,	4),
(3,	5),
(2,	6),
(5,	6),
(1,	6),
(4,	6),
(4,	7),
(5,	7),
(5,	8),
(1,	9),
(4,	10),
(1,	10),
(5,	10);

DROP TABLE IF EXISTS `availabilities`;
CREATE TABLE `availabilities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `availabilities_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `availabilities` (`id`, `name`, `weight`) VALUES
(1,	'disponible',	0),
(2,	'partiellement disponible',	1),
(3,	'non disponible',	2);

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `categories` (`id`, `name`, `weight`) VALUES
(1,	'Aide juridique',	0),
(2,	'Application cartographique web',	1),
(3,	'Carte statique',	2),
(4,	'Catalogue de métadonnées',	3),
(5,	'Coordination et gouvernance',	4),
(6,	'Directive INSPIRE',	5),
(7,	'Encadrement de la production de données',	6),
(8,	'Environnement informatique de développement',	7),
(9,	'Formation et sensibilisation',	8),
(10,	'Géoportail de la Wallonie',	9),
(11,	'Géoréférentiel',	10),
(12,	'Géotraitement',	11),
(13,	'Mutualisation, échange et diffusion interne et externe des géodonnées',	12),
(14,	'Outils SIG bureautique',	13),
(15,	'Service web géographique de visualisation',	14),
(16,	'Support aux utilisateurs',	15),
(17,	'Diffusion',	16),
(18,	'Métadonnées',	17),
(19,	'Référencement',	18);

DROP TABLE IF EXISTS `category_service`;
CREATE TABLE `category_service` (
  `category_id` int(10) unsigned NOT NULL,
  `service_id` int(10) unsigned NOT NULL,
  KEY `category_service_category_id_foreign` (`category_id`),
  KEY `category_service_service_id_foreign` (`service_id`),
  CONSTRAINT `category_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  CONSTRAINT `category_service_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `category_service` (`category_id`, `service_id`) VALUES
(11,	1),
(17,	1),
(12,	1),
(3,	1),
(14,	1),
(3,	2),
(2,	2),
(7,	2),
(5,	3),
(1,	3),
(4,	3),
(17,	4),
(7,	4),
(4,	5),
(11,	5),
(2,	5),
(16,	6),
(16,	7),
(14,	8),
(3,	8),
(11,	9),
(17,	10),
(6,	10),
(14,	10),
(3,	10);

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table',	1),
('2014_10_12_100000_create_password_resets_table',	1),
('2016_04_09_191205_create_services_table',	1),
('2016_04_10_105946_create_roles_table',	1),
('2016_04_10_110449_create_permissions_table',	1),
('2016_04_10_144151_create_revisions_table',	1),
('2016_04_29_111812_crate_availability_table',	1),
('2016_04_29_132550_create_categories_table',	1),
('2016_05_27_130406_add_delais_cout_table',	1),
('2016_05_27_131947_add_intervenants_procedure_table',	1),
('2016_05_27_134129_add_poste_column_table',	1);

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`),
  UNIQUE KEY `permissions_label_unique` (`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `permissions` (`id`, `name`, `label`, `description`) VALUES
(1,	'manage_permissions',	'Gestion des permissions',	'Permet d\'attribuer des permissions à un ou plusieurs rôles'),
(2,	'manage_users',	'Gestion des utilisateurs',	'Permet d\'ajouter/modifier/supprimer des utilisateurs et de leurs attribuer des rôles'),
(3,	'manage_categories',	'Gestion des catégories',	'Permet d\'ajouter/modifier/supprimer des catégories au service'),
(4,	'manage_availabilities',	'Gestion des disponibilitées',	'Permet d\'ajouter/modifier/supprimer des disponibilités au service'),
(5,	'service_create',	'Création d\'un service',	''),
(6,	'service_delete',	'Supprimer un service',	''),
(7,	'service_restore',	'Restaurer un service',	''),
(8,	'revision_validate',	'Valider une révision d\'un service',	''),
(9,	'revision_restore',	'Restaurer une révision validée d\'un service',	''),
(10,	'revision_delete',	'Supprimer une révision d\'un service',	'');

DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  KEY `permission_role_permission_id_foreign` (`permission_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1,	3),
(2,	3),
(3,	3),
(4,	3),
(5,	3),
(6,	3),
(7,	3),
(8,	3),
(9,	3),
(10,	3),
(5,	2),
(6,	2),
(8,	2),
(9,	2),
(10,	2),
(5,	1);

DROP TABLE IF EXISTS `revisions`;
CREATE TABLE `revisions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `field` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `old_value` text COLLATE utf8_unicode_ci,
  `new_value` text COLLATE utf8_unicode_ci,
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `revisions` (`id`, `name`, `service_id`, `user_id`, `field`, `old_value`, `new_value`, `valid`, `created_at`, `updated_at`) VALUES
(1,	'Création',	1,	NULL,	'created_at',	NULL,	'2016-05-30 12:53:00',	0,	'2016-05-30 10:53:00',	'2016-05-30 10:53:00'),
(2,	'Création',	2,	NULL,	'created_at',	NULL,	'2016-05-30 12:53:00',	0,	'2016-05-30 10:53:00',	'2016-05-30 10:53:00'),
(3,	'Création',	3,	NULL,	'created_at',	NULL,	'2016-05-30 12:53:00',	0,	'2016-05-30 10:53:00',	'2016-05-30 10:53:00'),
(4,	'Création',	4,	NULL,	'created_at',	NULL,	'2016-05-30 12:53:00',	0,	'2016-05-30 10:53:00',	'2016-05-30 10:53:00'),
(5,	'Création',	5,	NULL,	'created_at',	NULL,	'2016-05-30 12:53:00',	0,	'2016-05-30 10:53:00',	'2016-05-30 10:53:00'),
(6,	'Création',	6,	NULL,	'created_at',	NULL,	'2016-05-30 12:53:00',	0,	'2016-05-30 10:53:00',	'2016-05-30 10:53:00'),
(7,	'Création',	7,	NULL,	'created_at',	NULL,	'2016-05-30 12:53:00',	0,	'2016-05-30 10:53:00',	'2016-05-30 10:53:00'),
(8,	'Création',	8,	NULL,	'created_at',	NULL,	'2016-05-30 12:53:00',	0,	'2016-05-30 10:53:00',	'2016-05-30 10:53:00'),
(9,	'Création',	9,	NULL,	'created_at',	NULL,	'2016-05-30 12:53:00',	0,	'2016-05-30 10:53:00',	'2016-05-30 10:53:00'),
(10,	'Création',	10,	NULL,	'created_at',	NULL,	'2016-05-30 12:53:00',	0,	'2016-05-30 10:53:00',	'2016-05-30 10:53:00');

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `roles` (`id`, `name`, `weight`) VALUES
(1,	'ecrivain',	0),
(2,	'modérateur',	1),
(3,	'admin',	2);

DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `availability_id` int(11) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `description_categorie` text COLLATE utf8_unicode_ci,
  `contexte` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `exclus_perimetre` text COLLATE utf8_unicode_ci,
  `prerequis` text COLLATE utf8_unicode_ci,
  `contact_general` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `cout_client` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `delai_charge` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `delai_oeuvre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `delai_tiers` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `marge_securite` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remarque_delai` text COLLATE utf8_unicode_ci,
  `rh_interne` text COLLATE utf8_unicode_ci NOT NULL,
  `cout_externalisation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `agent_responsable` int(10) unsigned NOT NULL,
  `intervenants_externes` text COLLATE utf8_unicode_ci NOT NULL,
  `identifiant_procedure` text COLLATE utf8_unicode_ci NOT NULL,
  `resume_procedure` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_title_unique` (`title`),
  UNIQUE KEY `services_slug_unique` (`slug`),
  UNIQUE KEY `services_identifier_unique` (`identifier`),
  KEY `services_user_id_index` (`user_id`),
  KEY `services_availability_id_index` (`availability_id`),
  KEY `services_agent_responsable_foreign` (`agent_responsable`),
  CONSTRAINT `services_agent_responsable_foreign` FOREIGN KEY (`agent_responsable`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `services` (`id`, `title`, `slug`, `identifier`, `availability_id`, `user_id`, `description_categorie`, `contexte`, `description`, `exclus_perimetre`, `prerequis`, `contact_general`, `created_at`, `updated_at`, `deleted_at`, `cout_client`, `delai_charge`, `delai_oeuvre`, `delai_tiers`, `marge_securite`, `remarque_delai`, `rh_interne`, `cout_externalisation`, `agent_responsable`, `intervenants_externes`, `identifiant_procedure`, `resume_procedure`) VALUES
(1,	'Quia temporibus exercitationem',	'quia-temporibus-exercitationem',	'699',	3,	4,	'Voluptatem fugiat suscipit repellendus est praesentium architecto. Quo nihil voluptatem et dolorum atque culpa aut.',	'Mollitia consequatur quia beatae totam porro voluptas est. Aut ut voluptates aut a.',	'Omnis natus dolores aut similique qui et. Nobis ut aut tenetur temporibus et voluptatibus ratione dolorem. Molestiae facilis quos laborum aspernatur sed esse.',	'Eum aspernatur temporibus reiciendis et totam delectus. Mollitia tempora et et velit ipsa. Ea eum sit corporis fugit qui voluptas.',	'Et qui asperiores sint rem laboriosam. Repudiandae adipisci et quisquam impedit. Sint soluta occaecati dolores delectus velit quia explicabo.',	'61813 Stiedemann Skyway Suite 148 - 72824-1182 Marilieville',	'2016-05-30 10:53:00',	'2016-05-30 10:53:00',	NULL,	'454',	'43',	'27',	'7',	'23',	'Exercitationem ut veniam ut quaerat neque qui cumque quae. Dicta ea vel et dolor dolore molestias alias enim. Facilis animi voluptatem suscipit quam sed dolore.',	'Autem rerum soluta culpa aliquam ex. Sed nesciunt odit corrupti qui. Adipisci iste sed amet quibusdam quis.',	'748',	4,	'Garrett Dare',	'Et hic sequi voluptatum ipsam aut. Alias ea quia sit rem mollitia debitis rem enim. Delectus cum assumenda molestias quisquam nobis consectetur praesentium. In excepturi et tempora excepturi unde.',	'Suscipit sit quas necessitatibus delectus dicta quia. Beatae fugit ea dolorem quisquam facere mollitia. Asperiores quia numquam dicta non aliquid error non.'),
(2,	'Qui molestiae aut',	'qui-molestiae-aut',	'940',	2,	4,	'Voluptas unde fugiat corporis facilis distinctio eius. Corrupti sit excepturi ab laboriosam dolorum. Qui soluta similique velit cupiditate fugit est. Minus expedita ipsam consequatur non maiores modi voluptate quia.',	'Voluptatem perferendis rem aut temporibus. Earum laborum et sint nam ut quaerat delectus. Qui blanditiis dignissimos occaecati dolorem quia vero consequatur.',	'Asperiores minus in nemo. Provident non delectus consequatur enim. Blanditiis porro nam debitis quas voluptates. Sapiente et est cum consequatur necessitatibus assumenda delectus.',	'Omnis id dolorem at ut. Odio dolorem iusto consequatur dolorem.',	'Minima est numquam ratione veritatis sunt. Similique quisquam earum voluptatem possimus iste voluptatem facilis ducimus. Blanditiis dignissimos provident sequi dolores voluptate assumenda omnis.',	'28024 Cummerata Ramp Apt. 589 - 70813-0109 Oletaville',	'2016-05-30 10:53:00',	'2016-05-30 10:53:00',	NULL,	'370',	'50',	'8',	'13',	'28',	'Aut culpa ut atque veritatis natus. Iusto suscipit natus ut molestiae. Aperiam doloremque labore eaque consequatur provident animi corporis.',	'Et doloribus perspiciatis et corporis blanditiis quis consequatur. Iusto reprehenderit ad voluptatibus exercitationem. Facere deserunt quam eaque doloribus dolores.',	'211',	5,	'Deanna Powlowski',	'Neque aliquam reprehenderit soluta rerum. Incidunt quis autem est accusantium veritatis. Quidem itaque aliquid cum autem ipsum. Est molestiae ut maxime vel qui aspernatur aut.',	'Vel repudiandae qui fuga sunt. Adipisci est enim aspernatur quia repellat magni error. Soluta qui deserunt quisquam sit pariatur natus molestiae. Alias veritatis consequatur non ea soluta cumque.'),
(3,	'Mollitia optio ipsa',	'mollitia-optio-ipsa',	'900',	1,	1,	'Possimus autem nisi neque labore. Nam nam molestiae quidem officiis ut hic aut. Est ab nihil harum voluptas qui. Quis qui eligendi cum consequatur.',	'Maxime perspiciatis esse debitis quis. Praesentium dolorum et facilis. Laborum et aliquam debitis doloremque ratione cupiditate ea. Minus eligendi et est numquam laborum.',	'Eveniet voluptatem consectetur eum quas reprehenderit vel praesentium. Neque tempora veritatis qui et dolore. Nihil ea eos cumque veniam.',	'Quasi et consequatur magnam ut voluptas. Enim labore vitae rem fugiat numquam. Beatae velit aut est ipsum in praesentium. Voluptas eos totam similique vel vitae corrupti.',	'Eaque sunt et aperiam voluptatibus. Autem velit neque expedita voluptate. Aut reprehenderit eos nobis quia.',	'59217 Enos Stravenue - 12385 Port Bryce',	'2016-05-30 10:53:00',	'2016-05-30 10:53:00',	NULL,	'758',	'31',	'13',	'22',	'0',	'Eius ut deserunt et aliquam nesciunt. Praesentium officiis quo cumque. Omnis officia modi ratione laboriosam.',	'Blanditiis minus vel maiores quam nobis repellat assumenda consequuntur. Molestias sunt qui voluptas aut. Quis voluptas repellendus voluptas est dolor aut. Aut odit omnis est sunt libero ratione.',	'641',	4,	'Ms. Amaya Dietrich',	'Vel aliquam sint velit non ea. Sint fuga ipsa sed dolorem magnam culpa. Assumenda provident voluptatem esse sequi voluptatem. Quaerat omnis perspiciatis explicabo nobis a. Eaque mollitia vel aperiam magni.',	'Deleniti voluptates qui mollitia eum eum. Consectetur sit corrupti sapiente magni non aperiam recusandae. Et minus optio et vel. Ex fugit voluptatem non nostrum ut animi vel.'),
(4,	'Enim reprehenderit et',	'enim-reprehenderit-et',	'769',	1,	2,	'Et ipsum error consectetur doloribus consequatur. At eum qui et ut aspernatur eaque consequatur.',	'Quos commodi in facere ut. Optio sed sapiente rerum tempora vel sit. Voluptates soluta illo aut.',	'Ea consequatur quos omnis asperiores et. Sapiente optio aut voluptatum sed doloremque aliquam rem velit. Tenetur itaque enim non. Totam fuga quisquam est quia dolorum sapiente.',	'Accusamus quis et et qui atque. Inventore cupiditate occaecati tempore molestiae ut consequuntur. Ut est quia totam dolor rerum. Aut dolor ut voluptatum fugiat voluptatem consequatur voluptatem ad.',	'Sit eligendi ipsam non cum. Ipsum quos saepe in labore. Nulla et sit hic earum qui consequatur pariatur. Qui non vel assumenda nihil.',	'92758 Walker Union Apt. 850 - 61895 Marquiseburgh',	'2016-05-30 10:53:00',	'2016-05-30 10:53:00',	NULL,	'812',	'11',	'5',	'13',	'4',	'Eligendi commodi ex dignissimos. Neque et provident quia qui recusandae eum autem. Quisquam similique cum nostrum iste provident voluptas. Autem ea est ipsa in consequatur.',	'Et porro non at soluta ut consequatur. Fugit omnis ad similique occaecati cupiditate. Pariatur exercitationem minus doloremque cumque odit.',	'575',	4,	'Aniya Rippin',	'Maiores et similique nihil atque similique ut. Omnis eos qui cum recusandae eos. Eos odio iure in dolores veniam.',	'Magni error in qui suscipit. Architecto nobis ut illo. Nisi deleniti et ad et eos officiis molestias sint. Deleniti et et consequatur sit.'),
(5,	'Quidem minima sint',	'quidem-minima-sint',	'943',	2,	2,	'Ullam error exercitationem est est est. Delectus aut architecto quis dolores.',	'Occaecati consequatur repellendus excepturi quis molestiae. Perspiciatis perferendis maxime veritatis reiciendis sed sit. Modi accusamus tempore earum voluptate et ex. Quos aut laborum perspiciatis et odit animi.',	'Qui laudantium nesciunt enim. Nihil placeat vero hic dolorem perferendis provident consequatur aspernatur. Accusamus doloremque harum sapiente enim quam omnis fugit corporis. Molestiae iste harum aut recusandae numquam eius voluptas illo.',	'Aperiam beatae rem nihil consequatur sint error enim. Magni asperiores voluptatem ullam. Expedita optio eligendi corporis.',	'Rerum ea ipsum omnis consequatur. Autem veritatis et eligendi. Vitae doloribus atque laudantium aut id aut. Repudiandae eos porro et sint.',	'5091 Kamryn Drive - 40798 North Edward',	'2016-05-30 10:53:00',	'2016-05-30 10:53:00',	NULL,	'255',	'5',	'34',	'20',	'9',	'Commodi voluptates quibusdam enim. Et qui unde voluptatum odit et autem. Quos aperiam culpa et numquam. Nisi et sed error quam doloribus laudantium.',	'Saepe iusto placeat qui reprehenderit. Et odit nihil qui. Odio quae est aut et.',	'697',	1,	'Jamel Pollich',	'Qui itaque cumque dolores ullam quia placeat voluptas. Dolores eos voluptatem vel amet qui veritatis. Qui sunt labore repudiandae quia deserunt similique animi et.',	'Et repellat et ullam maxime accusantium assumenda voluptatem. Eligendi consequuntur consequatur et architecto. Accusantium explicabo labore adipisci vero libero magni sequi.'),
(6,	'Dicta nam sint',	'dicta-nam-sint',	'353',	3,	3,	'Expedita ad eos distinctio minus sed. Ad velit deleniti accusantium provident voluptatem id eum. Ut ea quia animi modi.',	'Odio ullam aut consequatur quas. Commodi non qui quidem dolores soluta nobis. Consequatur non natus laudantium eum corporis. Tempore et velit animi vel eum esse.',	'Commodi voluptatem ducimus sint officiis est atque aut cumque. Non voluptas et similique suscipit saepe placeat. Aliquid totam totam laboriosam qui aut qui esse.',	'Nemo eius nisi nisi unde dolor exercitationem dolorem. Necessitatibus aut laboriosam magnam aut. Commodi sint alias et eaque voluptate. Voluptatum blanditiis sunt ut molestiae.',	'Ut minima sed quidem dignissimos. Amet aut dolorem ab velit quidem et. Corrupti quo blanditiis vel error quod. Aliquid sunt ex ipsum et sit sed quibusdam.',	'5059 Hipolito Ramp Suite 119 - 59325 Port Victoria',	'2016-05-30 10:53:00',	'2016-05-30 10:53:00',	NULL,	'769',	'26',	'24',	'2',	'35',	'Velit error et et rerum animi iure. Alias ut quasi similique sint. Aut aut placeat corporis non mollitia nam aut reiciendis. Consequatur sint aut perspiciatis enim omnis.',	'Rerum exercitationem est assumenda at quia dicta. Quo qui aliquam commodi placeat odit reiciendis perspiciatis. Vel laborum culpa consequuntur voluptas pariatur dolor aut. Laboriosam ad et esse illo sint.',	'992',	3,	'Destany Krajcik',	'Illum sit dolores omnis ullam corporis. Nam et similique earum libero. Fuga occaecati sit voluptatem debitis. Rerum quia qui qui.',	'Quibusdam cupiditate omnis voluptatibus beatae facere sunt nulla. Ea nulla in rerum odio magni. Officiis pariatur voluptatem ab. Consectetur ipsa qui in cum perspiciatis vero. Voluptas voluptates aspernatur qui animi similique nulla aut et.'),
(7,	'Dolorem eos vitae',	'dolorem-eos-vitae',	'781',	2,	2,	'Voluptatum quisquam et sint velit. Sapiente distinctio voluptates iste et est. Eligendi magnam cum id sed nesciunt sunt. Fugit sunt ut voluptatibus explicabo itaque ratione.',	'Ut omnis fugiat ut perspiciatis. Corporis consequuntur minus officiis amet nostrum dolorem et. Qui ut at sint.',	'Id exercitationem iste inventore sint. Ut praesentium quia eos qui esse. Voluptates culpa aut nihil reprehenderit quis et. Qui autem provident sed deserunt nisi.',	'Voluptatum nisi quas praesentium asperiores soluta quas eveniet consequatur. Tenetur et dolorem aspernatur nam consequatur.',	'Voluptatem ut autem quia tempora dignissimos eum officia. Ut voluptatum eos id adipisci distinctio.',	'370 Yundt Rapids Apt. 497 - 41832 Jastview',	'2016-05-30 10:53:00',	'2016-05-30 10:53:00',	NULL,	'164',	'0',	'45',	'14',	'12',	'Quidem ratione nesciunt laborum. Voluptatem molestiae expedita optio ipsam eius ipsam. Velit deserunt suscipit aut incidunt maxime et fuga. Rerum iste fuga sunt animi aliquam reiciendis. Repellat et dolore minus sed.',	'Voluptatem ipsa quas ut nostrum. Commodi veniam ut quidem quod cupiditate est. Perspiciatis dolor dicta aut voluptate voluptas aut.',	'609',	1,	'Rosie Schowalter',	'Nobis alias eos velit id dolor qui. Cumque alias quibusdam laudantium aliquid neque similique possimus. Earum eum ut enim voluptatum adipisci dolor. Distinctio quia eum minus rerum.',	'Aut voluptatum qui eos quis. Illum officia ut placeat cupiditate non et.'),
(8,	'Illo maxime ad',	'illo-maxime-ad',	'191',	1,	4,	'Minima quod animi similique ut exercitationem. Blanditiis at alias sed qui animi laborum. Aliquam minima expedita voluptate. Excepturi numquam dicta accusamus.',	'Doloribus cupiditate sunt et omnis porro aliquam. Quisquam quaerat dicta est non. Quos esse repellendus fugiat veniam eligendi similique porro. Culpa doloremque qui quibusdam numquam.',	'Hic neque ut eum ducimus aspernatur sed sit. Et optio nulla molestias recusandae saepe. Sint qui et voluptatem qui fugit optio ea qui. Officiis rerum autem expedita velit perferendis accusantium repudiandae.',	'Facere voluptatibus rerum praesentium eaque. Aperiam nostrum sunt praesentium temporibus. Quidem et quaerat voluptas voluptatem dolores reiciendis accusantium aspernatur. Libero velit ad dolores illum et provident qui quis.',	'Repellat ullam sunt minima est incidunt. Aut omnis numquam ducimus corporis. Corporis dolore vel molestiae perferendis aut qui. Quisquam qui quis voluptatum possimus aspernatur velit.',	'97474 Durgan Village - 75775-1257 Dustinborough',	'2016-05-30 10:53:00',	'2016-05-30 10:53:00',	NULL,	'369',	'14',	'43',	'5',	'17',	'Sit autem sit iste autem non. Repellat dolorem exercitationem ut iste voluptate. Iste id est facilis odio sapiente. Reprehenderit cumque sit quaerat.',	'Sit officia labore eius ipsum facilis. Commodi deserunt labore accusantium non architecto. Fugiat quos sapiente labore incidunt deserunt veritatis ea.',	'901',	4,	'Dave Wintheiser',	'Cupiditate deleniti eos laborum velit adipisci odit autem. Reiciendis reprehenderit sed omnis et veniam similique quia. Quas quas aut et reiciendis. Quia voluptas odit illum saepe dolores error.',	'Qui nobis reiciendis facilis sequi. Cum dicta et non expedita rerum eos. Occaecati et sint autem voluptatibus fugiat.'),
(9,	'Distinctio est inventore',	'distinctio-est-inventore',	'11',	3,	2,	'Aut id omnis veniam est ut voluptate eos. Maxime dolores aut voluptates voluptatem. Veritatis sit maiores quam voluptate et explicabo. Cum alias et consequatur.',	'Dolorum ab quasi dolore enim incidunt beatae. Dolorum esse id ipsam illum inventore officiis corporis. Id minima velit et quasi molestiae ab quod.',	'Delectus quo id et aperiam nulla consequatur molestiae. Dolorem ex quae numquam qui. Totam reiciendis accusantium dolores iste eveniet similique. Aut velit nemo commodi rem nemo officia.',	'Praesentium corrupti occaecati assumenda ea qui. Eos facilis dolor quia quia id consequatur labore nihil. Voluptas et magni ea perferendis blanditiis officia.',	'Dolores sed quisquam repellendus perferendis numquam. Officiis nisi aut esse enim eaque dolores. Quis fugit dolor in beatae praesentium qui ipsa. Repudiandae reprehenderit voluptas voluptate corrupti et.',	'83538 Tremblay Hill Suite 398 - 76470 Elveraburgh',	'2016-05-30 10:53:00',	'2016-05-30 10:53:00',	NULL,	'614',	'29',	'42',	'40',	'12',	'Perspiciatis aspernatur dolorem rem nulla. Reprehenderit et et expedita odit hic distinctio nemo omnis. Error aliquid id necessitatibus accusamus sed aliquid ut est. Vero tempore sit amet eveniet exercitationem.',	'Sed doloremque exercitationem dolores dicta alias. Totam officia dolorem et nam. Et excepturi soluta similique doloribus.',	'627',	2,	'Cedrick Carroll',	'Sint tenetur voluptate ratione laboriosam. Delectus ea nemo ipsam minima. Voluptates accusantium animi sed. Non ut labore sequi magni sunt.',	'Ex sunt qui eum rerum. Et neque rerum itaque sed porro. Sint repellat ullam animi aut tempore est. Autem numquam id repellat sunt quia ducimus.'),
(10,	'Est voluptatem quaerat',	'est-voluptatem-quaerat',	'618',	1,	3,	'Sapiente rerum non et impedit ad repellat. Ipsum a modi qui cumque. Expedita ut non dicta tempore qui. Aut recusandae ut harum quo ab ullam.',	'Incidunt dicta quidem impedit est qui debitis. Mollitia consequatur libero reiciendis sed maxime. Maiores voluptatibus possimus fuga atque libero quo eos id. Autem repellat ea itaque aspernatur minus minus non consequatur.',	'Consequatur qui veritatis culpa iusto. Nemo itaque facere inventore expedita facere. Modi corrupti at architecto asperiores suscipit eos. Pariatur molestias vero impedit aut facere.',	'Ea reprehenderit a perspiciatis temporibus. Assumenda ex dolorem et deserunt qui minus fugit aut. Consequuntur fugiat architecto commodi quisquam. Quidem esse debitis quae.',	'Iste non qui est illo voluptatem harum repellat ut. Quis dolorem beatae quo et vel. Eos explicabo non corporis praesentium ea exercitationem.',	'5423 Leonor Island - 58274-0231 Bridgettestad',	'2016-05-30 10:53:00',	'2016-05-30 10:53:00',	NULL,	'502',	'30',	'8',	'40',	'4',	'Repellendus accusantium laudantium facilis ad eligendi accusantium mollitia. Pariatur blanditiis explicabo libero tempora. Autem hic ut perferendis voluptatem. Sequi maxime accusamus assumenda placeat at consequatur temporibus.',	'Cupiditate ad voluptatem doloribus id labore sunt. Consequatur est ipsum repellat adipisci quo adipisci aspernatur. Debitis quisquam perferendis rerum commodi ducimus ducimus. A est fugit libero labore ea.',	'189',	2,	'Dr. Monte Heidenreich Sr.',	'Quo harum dignissimos beatae a voluptatem ut magnam. Consequatur quia quis sit atque aperiam asperiores labore. Veniam iste temporibus consequatur odio velit. Repudiandae doloribus mollitia nisi in id amet quia.',	'Animi vitae vel labore eaque non nobis. Expedita velit eius eligendi et. Omnis aut sed quibusdam id quae quo ipsa fugiat. Et eum aut id. Perferendis qui nobis dignissimos et possimus eum ipsum.');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `poste` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_index` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role_id`, `active`, `remember_token`, `created_at`, `updated_at`, `poste`) VALUES
(1,	'Admin',	'admin@dig.be',	'$2y$10$kUofMjuSM/xA3kSFQmWb4.BMXPOUUWANtXb1etxgQYAj42wqiWnjO',	3,	1,	'ygDhVAgTEtwnRzyLU6r118S8ecaAXDyXpssfDzWV4Zjs7Mv0amwfvyhQMs82',	'2016-05-30 10:52:59',	'2016-05-30 10:53:34',	'Informaticien / Développeur'),
(2,	'Brennon Schiller',	'heller.meda@gmail.com',	'$2y$10$JGvbNIem9Wk.Rf1ExUPF/eXr0plpQ4vusqMJvJgdBkCcwkVE51DUG',	2,	1,	'O5x8qujxTCfCaA2WVtbLpstmFXQAhqAOL2bF16K21iTUhAjx1FvYx1EiSYRu',	'2016-05-30 10:52:59',	'2016-05-30 10:52:59',	'Elementary School Teacher'),
(3,	'Bertrand Ankunding DDS',	'hagenes.willa@dare.org',	'$2y$10$iBOuJIlsi5t7x/JQk.pHUOqP46nNg5UBjQVAhUX4bAOpElEEWTZ8S',	2,	1,	'OVPSjMscdZrQakLvx8F1b5ONxDLKSUL168Qg4NchvYtErpn11mFkLsVTgNpE',	'2016-05-30 10:52:59',	'2016-05-30 10:52:59',	'Public Relations Manager'),
(4,	'Mrs. Georgianna Rodriguez MD',	'goyette.penelope@yahoo.com',	'$2y$10$8fFTtYw6pi2LVBpmO7V5t.vCQ5V9OgCnoHDjaltlM/J2hhxZRQ5XS',	1,	1,	'Fzbc0hXQF9RKNJzjj2rJmFRSoKa3oKWPMGZdmVSeavqJv5AvWFhtgRPNipwp',	'2016-05-30 10:52:59',	'2016-05-30 10:52:59',	'Refrigeration Mechanic'),
(5,	'Marcella West',	'quincy60@kovacek.com',	'$2y$10$KOUyGK6VhUNoPetwmlqcJ.6epj0fm7F97loIMInV3q5dXV/NXvWKW',	1,	1,	'VdOdmlFxrvu3XnSgw7AI36KLbIZCFl9mwt5gVEzgQNbX5hrUbUX6HVERPv0X',	'2016-05-30 10:52:59',	'2016-05-30 10:52:59',	'Teller');

-- 2016-05-30 11:08:25
