.PHONY: new-instance dependencies

new-instance:
	@lando start
	@lando db-import scripts/base.db.sql.gz
	@echo username: admin password: drupal8
	@lando drush en todo_lists -y
	@lando drush cr

dependencies:
	@composer install