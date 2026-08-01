SET NAMES utf8mb4;
CREATE DATABASE IF NOT EXISTS quorion CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE quorion;

CREATE TABLE site_settings (
    setting_key VARCHAR(100) NOT NULL PRIMARY KEY,
    setting_value TEXT NOT NULL,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE content_blocks (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    block_key VARCHAR(100) NOT NULL UNIQUE,
    eyebrow VARCHAR(160) NOT NULL DEFAULT '',
    title VARCHAR(255) NOT NULL DEFAULT '',
    content TEXT NOT NULL,
    image_path VARCHAR(255) NOT NULL DEFAULT '',
    button_text VARCHAR(100) NOT NULL DEFAULT '',
    button_url VARCHAR(255) NOT NULL DEFAULT '',
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE company_values (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    icon VARCHAR(80) NOT NULL DEFAULT 'fa-check',
    title VARCHAR(160) NOT NULL,
    description TEXT NOT NULL,
    display_order INT UNSIGNED NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE services (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    icon VARCHAR(80) NOT NULL DEFAULT 'fa-laptop-code',
    title VARCHAR(160) NOT NULL,
    description TEXT NOT NULL,
    display_order INT UNSIGNED NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE projects (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(160) NOT NULL,
    title VARCHAR(160) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    project_url VARCHAR(255) NOT NULL DEFAULT '',
    display_order INT UNSIGNED NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE contact_messages (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(160) NOT NULL,
    email VARCHAR(190) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE newsletter_subscribers (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(190) NOT NULL UNIQUE,
    subscribed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE admins (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(160) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO site_settings (setting_key, setting_value) VALUES
('site_name', 'QUORION'),
('meta_description', 'QUORION accompagne les organisations avec des solutions digitales innovantes, simples et fiables.'),
('hero_title', 'Transformer vos défis en opportunités grâce au numérique.'),
('hero_text', 'Nous concevons des solutions digitales sur mesure qui simplifient vos opérations, améliorent vos performances et créent une valeur durable.'),
('hero_primary_button', 'Nos solutions'),
('hero_secondary_button', 'Nous contacter'),
('address', 'Adresse à définir'),
('phone', '+00 000 000 000'),
('email', 'contact@quorion.com'),
('newsletter_text', 'Recevez les actualités et les idées qui font avancer votre transformation numérique.'),
('twitter_url', '#'),
('facebook_url', '#'),
('youtube_url', '#'),
('instagram_url', '#'),
('linkedin_url', '#');

INSERT INTO content_blocks (block_key, eyebrow, title, content, image_path, button_text, button_url) VALUES
('about', 'À propos de nous', 'Des technologies utiles, innovantes et accessibles.', 'QUORION accompagne les entreprises, les PME, les organisations sociales, les ONG, les institutions et les entrepreneurs dans la conception et le développement de solutions digitales adaptées à leurs réalités. Nous créons des outils qui simplifient les opérations, améliorent la performance et facilitent la prise de décision.', 'SeoMaster/img/about.jpg', 'En savoir plus', 'about.php'),
('mission', 'Notre mission', 'Accélérer votre transformation numérique.', 'Concevoir, développer et intégrer des solutions digitales innovantes qui permettent aux entreprises, PME, organisations sociales, ONG et institutions d’améliorer leurs performances, d’optimiser leurs processus et d’accélérer leur transformation numérique.', '', '', ''),
('vision', 'Notre vision', 'Une référence durable et fiable.', 'Devenir une référence dans la conception de solutions digitales innovantes, reconnue pour son excellence, sa fiabilité et sa capacité à accompagner durablement les organisations dans leur évolution numérique.', '', '', ''),
('approach', 'Notre approche', 'Écouter, analyser et collaborer.', 'Chaque organisation est unique. Nous prenons le temps de comprendre votre environnement, vos objectifs et vos défis afin de concevoir une solution sur mesure, évolutive et parfaitement adaptée à vos besoins.', '', '', ''),
('why', 'Pourquoi choisir QUORION ?', 'Des solutions adaptées à vos réalités.', 'Nous ne développons pas seulement des logiciels. Nous concevons des solutions qui répondent aux réalités de votre organisation et produisent des résultats concrets, fiables et évolutifs.', '', '', ''),
('signature', 'Notre signature', 'Votre réussite est la meilleure mesure de la nôtre.', 'Ancrés dans la confiance, animés par l’innovation et guidés par la simplicité, nous concevons des solutions digitales qui transforment les idées en valeur durable et optimisent vos performances.', '', '', '');

INSERT INTO company_values (icon, title, description, display_order) VALUES
('fa-handshake', 'Confiance', 'Nous bâtissons des relations durables fondées sur la transparence, l’intégrité et le respect de nos engagements.', 1),
('fa-lightbulb', 'Innovation', 'Nous explorons en permanence les nouvelles technologies afin d’imaginer les solutions de demain.', 2),
('fa-award', 'Excellence', 'Nous accordons une attention particulière à la qualité, à la sécurité et à la performance de chacune de nos réalisations.', 3),
('fa-users', 'Collaboration', 'Les meilleures solutions naissent du partage des idées et d’une relation de proximité avec nos clients.', 4),
('fa-check', 'Simplicité', 'Nous transformons la complexité technologique en solutions intuitives, accessibles et centrées sur l’utilisateur.', 5);

INSERT INTO services (icon, title, description, display_order) VALUES
('fa-laptop-code', 'Logiciels sur mesure', 'Des logiciels adaptés à vos processus, à vos objectifs et à vos réalités opérationnelles.', 1),
('fa-mobile-alt', 'Applications mobiles', 'Des applications Android et iOS intuitives pour prolonger vos services là où vos utilisateurs en ont besoin.', 2),
('fa-cogs', 'Optimisation des processus', 'Des outils numériques qui simplifient vos opérations et améliorent durablement votre efficacité.', 3),
('fa-chart-line', 'Aide à la décision', 'Une meilleure exploitation de l’information pour éclairer vos décisions et piloter votre croissance.', 4),
('fa-shield-alt', 'Solutions fiables et évolutives', 'Une attention constante à la sécurité, la qualité et la performance de vos solutions.', 5),
('fa-people-arrows', 'Accompagnement digital', 'Une collaboration de proximité, de l’analyse de vos besoins à l’évolution de votre solution.', 6);

INSERT INTO projects (category, title, image_path, display_order) VALUES
('Solutions digitales', 'Solution de gestion opérationnelle', 'SeoMaster/img/portfolio-1.jpg', 1),
('Applications mobiles', 'Application mobile métier', 'SeoMaster/img/portfolio-2.jpg', 2),
('Collaboration', 'Plateforme collaborative', 'SeoMaster/img/portfolio-3.jpg', 3),
('Pilotage', 'Outil d’aide à la décision', 'SeoMaster/img/portfolio-4.jpg', 4),
('Organisation sociale', 'Solution de suivi de programme', 'SeoMaster/img/portfolio-5.jpg', 5),
('Institution', 'Portail de services numériques', 'SeoMaster/img/portfolio-6.jpg', 6);

INSERT INTO admins (name, email, password_hash) VALUES
('Administrateur QUORION', 'admin@quorion.local', '$2y$10$OB7wnfX642mDYPrgoDa0uux3ysQ4jXXsE90LRG.Zr/zPRQCBOxfWK');
