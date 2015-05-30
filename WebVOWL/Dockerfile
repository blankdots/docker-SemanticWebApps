#WebVOWL Dockerfile v 0.1.2

# Base image
FROM debian:jessie

#Dockerfile maintainer
MAINTAINER blankdots <blankdots@gmail.com>

#export DEBIAN_FRONTEND noninteractive
ENV DEBIAN_FRONTEND noninteractive

#Install OS tools needed
RUN \
        apt-get update && \
	apt-get -y install nodejs && \
	apt-get -y install npm && \
	apt-get -y install git

RUN apt-get clean

# Make symbolic link to "node" since code was written for OSX and linux refers to "node" as "nodejs"
RUN ln -s /usr/bin/nodejs /usr/bin/node

#Expose port 8000 for WebVOWL
#Expose port 35729 for livereload
EXPOSE 8000 35729

RUN git clone https://github.com/blankdots/WebVOWL.git /root/webvowl
RUN \
	cd /root/webvowl && \
	npm install && \
	npm install grunt-cli -g 

# Set environment variables
ENV HOME /root/webvowl

# Define working directory
WORKDIR /root/webvowl

# Define default command
CMD grunt webserver