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

FROM openjdk:14-jdk-slim-buster

RUN apt-get update; \
    apt-get install -y --no-install-recommends \
    bash wget ca-certificates findutils coreutils pwgen procps gosu; \
    rm -rf /var/lib/apt/lists/*

# Update below according to https://jena.apache.org/download/
ENV FUSEKI_SHA512 c0b9ab61a57f2c0e027f9d1a07710a22e672eb87730a6460b0869f6a6997a2628703bd99b1590bccd38bdc2a0f78d7be17890b4b88f65ef5518c882c8736a6b3
ENV FUSEKI_VERSION 4.0.0
ENV FUSEKI_MIRROR http://www.eu.apache.org/dist/
ENV FUSEKI_ARCHIVE http://archive.apache.org/dist/

# Installation folder
RUN mkdir /jena-fuseki
ENV FUSEKI_HOME /jena-fuseki

WORKDIR /tmp
# md5 checksum
RUN echo "$FUSEKI_SHA512  apache-jena-fuseki-${FUSEKI_VERSION}.tar.gz" > apache-jena-fuseki-$FUSEKI_VERSION.tar.gz.sha512
# Download/check/unpack/move in one go (to reduce image size)
RUN wget $FUSEKI_MIRROR/jena/binaries/apache-jena-fuseki-$FUSEKI_VERSION.tar.gz \
    || wget $FUSEKI_ARCHIVE/jena/binaries/apache-jena-fuseki-$FUSEKI_VERSION.tar.gz \
    && sha512sum -c apache-jena-fuseki-$FUSEKI_VERSION.tar.gz.sha512 \
    && tar zxf apache-jena-fuseki-$FUSEKI_VERSION.tar.gz \
    && mv apache-jena-fuseki-$FUSEKI_VERSION/* $FUSEKI_HOME \
    && rm apache-jena-fuseki-$FUSEKI_VERSION.tar.gz \
    && cd $FUSEKI_HOME && rm -rf fuseki.war

# Adding user without root privileges alongside a user group
RUN groupadd -r nonroot && useradd -r -g nonroot nonroot 

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
RUN chmod 755 /jena-fuseki/load.sh /jena-fuseki/tdbloader \
    /jena-fuseki/start-fuseki.sh /docker-entrypoint.sh /jena-fuseki/fuseki-server

# Config and data volume
# The volume needs to be set after the directory has been created to avoid
# permissions issues
VOLUME /data/fuseki/fuseki_DB
ENV FUSEKI_BASE /data/fuseki

# setting environment variables for entrypoint script
# setting also directories to be owned by the nonroot user
ENV GOSU_USER nonroot:nonroot
ENV GOSU_CHOWN /jena-fuseki /data

# Where we start our server from
WORKDIR /jena-fuseki

EXPOSE 3030

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["/jena-fuseki/start-fuseki.sh"]
