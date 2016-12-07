#WebVOWL Dockerfile v 0.1.2

# Base image
FROM mhart/alpine-node:base-6

MAINTAINER blankdots 

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

ADD converter.php .
ADD 

# Define default command
CMD grunt webserver