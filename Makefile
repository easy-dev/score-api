.PHONY: test-all

test-all: test-spec test-behat

test-spec:
	vendor/bin/phpspec -v run

test-behat:
	vendor/bin/behat