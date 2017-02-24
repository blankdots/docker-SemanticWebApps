#!/bin/bash
FUSEKI_BASE=/data/fuseki
FUSEKI_OPTS=${FUSEKI_OPTS:-"--config $FUSEKI_BASE/config/config.ttl"}
cd /jena-fuseki/
./fuseki-server $FUSEKI_OPTS
