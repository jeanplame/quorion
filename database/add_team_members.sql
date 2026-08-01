SET NAMES utf8mb4;
USE quorion;

CREATE TABLE IF NOT EXISTS team_members (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(160) NOT NULL,
    position VARCHAR(160) NOT NULL,
    bio TEXT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    facebook_url VARCHAR(255) NOT NULL DEFAULT '',
    twitter_url VARCHAR(255) NOT NULL DEFAULT '',
    instagram_url VARCHAR(255) NOT NULL DEFAULT '',
    linkedin_url VARCHAR(255) NOT NULL DEFAULT '',
    display_order INT UNSIGNED NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET @add_facebook_url = IF(
    (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'team_members' AND COLUMN_NAME = 'facebook_url') = 0,
    'ALTER TABLE team_members ADD COLUMN facebook_url VARCHAR(255) NOT NULL DEFAULT '''' AFTER image_path',
    'SELECT 1'
);
PREPARE statement FROM @add_facebook_url;
EXECUTE statement;
DEALLOCATE PREPARE statement;

SET @add_twitter_url = IF(
    (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'team_members' AND COLUMN_NAME = 'twitter_url') = 0,
    'ALTER TABLE team_members ADD COLUMN twitter_url VARCHAR(255) NOT NULL DEFAULT '''' AFTER facebook_url',
    'SELECT 1'
);
PREPARE statement FROM @add_twitter_url;
EXECUTE statement;
DEALLOCATE PREPARE statement;

SET @add_instagram_url = IF(
    (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'team_members' AND COLUMN_NAME = 'instagram_url') = 0,
    'ALTER TABLE team_members ADD COLUMN instagram_url VARCHAR(255) NOT NULL DEFAULT '''' AFTER twitter_url',
    'SELECT 1'
);
PREPARE statement FROM @add_instagram_url;
EXECUTE statement;
DEALLOCATE PREPARE statement;

INSERT INTO team_members (name, position, bio, image_path, display_order)
SELECT 'Membre QUORION', 'Direction stratégique', 'Coordination de la vision, des partenariats et de la qualité des solutions.', 'SeoMaster/img/portfolio-1.jpg', 1
WHERE NOT EXISTS (SELECT 1 FROM team_members);

INSERT INTO team_members (name, position, bio, image_path, display_order)
SELECT 'Membre QUORION', 'Ingénierie logicielle', 'Conception et développement de solutions fiables, simples et évolutives.', 'SeoMaster/img/portfolio-2.jpg', 2
WHERE (SELECT COUNT(*) FROM team_members) < 2;

INSERT INTO team_members (name, position, bio, image_path, display_order)
SELECT 'Membre QUORION', 'Accompagnement digital', 'Analyse des besoins, suivi des projets et proximité avec les organisations accompagnées.', 'SeoMaster/img/portfolio-3.jpg', 3
WHERE (SELECT COUNT(*) FROM team_members) < 3;
