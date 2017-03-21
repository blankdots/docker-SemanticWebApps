
# Base image
FROM centos:centos7

#Dockerfile maintainer
MAINTAINER blankdots <blankdots@gmail.com>

# Install Java
RUN yum install -y java git ant

# Expose Default Port
EXPOSE 9999
ENV BLAZEGRAPH_VERSION BLAZEGRAPH_RELEASE_1_5_1
ENV JAVA_HOME /usr/lib/jvm/java
ENV PATH $JAVA_HOME/bin:$PATH

WORKDIR /

# Install bigdata (blazegraph)
RUN git clone -b $BLAZEGRAPH_VERSION --single-branch git://git.code.sf.net/p/bigdata/git blazegraph

WORKDIR /blazegraph

# Exec on start
ENTRYPOINT ["ant", "start-blazegraph"]
