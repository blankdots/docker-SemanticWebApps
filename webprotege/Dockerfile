# webprotege

FROM tomcat:7
MAINTAINER blankdots <blankdots@gmail.com>
ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update
# Install unzip
RUN apt-get install -y unzip
# Install curl
RUN apt-get install -y curl
RUN apt-get install -y openjdk-7-jdk

# Taken from https://github.com/carlossg/docker-maven/blob/master/jdk-7/Dockerfile
WORKDIR /data/webprotege

RUN curl -L https://github.com/protegeproject/webprotege/releases/download/v2.5.0/webprotege-2.5.0.zip -o webprotege-2.5.0.zip

RUN unzip -q webprotege-2.5.0.zip

WORKDIR /

RUN rm -rf /usr/local/tomcat/webapps/ROOT/* \
    && mv /data/webprotege/webprotege-2.5.0.war /usr/local/tomcat/webapps/ROOT/ \
    && cd /usr/local/tomcat/webapps/ROOT/ \
    && jar -xvf webprotege-2.5.0.war

EXPOSE 8080

#COPY ./startup.sh /startup.s
#RUN chmod +x /startup.sh
#CMD ["/startup.sh"]