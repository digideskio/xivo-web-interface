.PHONY: test-image test-setup distclean

MANAGE_DB_DIR=../../xivo-manage-db/
POSTGRES_DOCKER=$(MANAGE_DB_DIR)/contribs/xivo-postgres/Dockerfile


test-setup:
	docker build -t xivo/xivo-postgres -f $(POSTGRES_DOCKER) $(MANAGE_DB_DIR)
	docker build -t xivo/xivo-web-interface ..
	docker pull n3llyb0y/wait

test-image:
	docker build --no-cache -t xivo-webi-test -f Dockerfile ..

test:
	nosetests suite

stop:
	cd assets/funckeys && \
	docker-compose kill && \
	docker-compose rm -f

start:
	cd assets/funckeys && \
	docker-compose run --service-ports --rm tests

distclean:
	docker rmi xivo/xivo-postgres
	docker rmi xivo-confd-test