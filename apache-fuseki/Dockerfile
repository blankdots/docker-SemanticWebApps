#   Licensed to the Apache Software Foundation (ASF) under one or more
#   contributor license agreements.  See the NOTICE file distributed with
#   this work for additional information regarding copyright ownership.
#   The ASF licenses this file to You under the Apache License, Version 2.0
#   (the "License"); you may not use this file except in compliance with
#   the License.  You may obtain a copy of the License at
#
#       http://www.apache.org/licenses/LICENSE-2.0
#
#   Unless required by applicable law or agreed to in writing, software
#   distributed under the License is distributed on an "AS IS" BASIS,
#   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
#   See the License for the specific language governing permissions and
#   limitations under the License.

# This Dockerfile was extended from https://hub.docker.com/r/stain/jena-fuseki/

FROM java:8-jre-alpine

MAINTAINER Stefan Negru <stefan.negru@helsinki.fi>

RUN apk add --update\
    && apk add --no-cache pwgen \
    && apk add --no-cache linux-headers \
    && apk add --no-cache bash \
    && apk add --no-cache ca-certificates \
    && apk add --no-cache wget

# Update below according to https://jena.apache.org/download/
ENV FUSEKI_MD5 6d954d7c57602dfc131bf7fbcb75c71d
ENV FUSEKI_VERSION 2.5.0
ENV FUSEKI_MIRROR http://www.eu.apache.org/dist/
ENV FUSEKI_ARCHIVE http://archive.apache.org/dist/

# Config and data volume
VOLUME /data/fuseki/fuseki_DB
ENV FUSEKI_BASE /data/fuseki

# Installation folder
RUN mkdir /jena-fuseki
ENV FUSEKI_HOME /jena-fuseki

WORKDIR /tmp
# sha1 checksum
RUN echo "$FUSEKI_MD5  apache-jena-fuseki-2.5.0.tar.gz" > apache-jena-fuseki-$FUSEKI_VERSION.tar.gz.md5
# Download/check/unpack/move in one go (to reduce image size)
RUN wget $FUSEKI_MIRROR/jena/binaries/apache-jena-fuseki-$FUSEKI_VERSION.tar.gz \
    || wget $FUSEKI_ARCHIVE/jena/binaries/apache-jena-fuseki-$FUSEKI_VERSION.tar.gz \
    && md5sum -c apache-jena-fuseki-$FUSEKI_VERSION.tar.gz.md5 \
    && tar zxf apache-jena-fuseki-$FUSEKI_VERSION.tar.gz \
    && mv apache-jena-fuseki-$FUSEKI_VERSION/* $FUSEKI_HOME \
    && rm apache-jena-fuseki-$FUSEKI_VERSION.tar.gz \
    && cd $FUSEKI_HOME && rm -rf fuseki.war

# As "localhost" is often inaccessible within Docker container,
# we'll enable basic-auth with a preset admin password
# (which we'll generate on start-up)
COPY shiro.ini /jena-fuseki/shiro.ini
COPY docker-entrypoint.sh /

# Adding configuration to the Graph Store and associated data
# at the same time modifing start script
ADD data /data/fuseki/config/data/
COPY config.ttl /data/fuseki/config/config.ttl
COPY start-fuseki.sh /jena-fuseki/start-fuseki.sh
# Create volume for data store

COPY load.sh /jena-fuseki/
COPY tdbloader /jena-fuseki/
RUN chmod 755 /jena-fuseki/load.sh /jena-fuseki/tdbloader /jena-fuseki/start-fuseki.sh /docker-entrypoint.sh

# Where we start our server from
WORKDIR /jena-fuseki
EXPOSE 3030
ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["/jena-fuseki/start-fuseki.sh"]
