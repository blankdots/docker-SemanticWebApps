## DockerRecipe for Blazegraph

Docker recipe for Blazegraph: http://www.blazegraph.com/

Author: http://blankdots.com

### Build Instructions

In the blazegraph folder, after docker has been installed and configured run on separately:

```
docker build -t blankdots/blazegraph .
docker images
docker run -p <dockerip>:9999:9999 -i -t blankdots/blazegraph
```
> `<dockerip>` (optional) - represents IP of docker can be determined using `boot2docker ip`

In your browser go to:
```
dockerip:9999
```

Cleaning all the containers and images:
```
docker rm $(docker ps -a -q)
docker rmi $(docker images -q)
```

Using bash inside the container:
```
docker run -i -t blankdots/blankdots bash
```

Connecting to a running container:
```
docker exec <image> -it sh
```

> The `<image>` can be determine using `docker ps`
