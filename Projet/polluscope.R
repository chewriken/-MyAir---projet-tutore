

#install.packages('ggmap()')
#library(ggmap)
#library(ggplot2)
#library(ggthemes)

setwd("C:/polluscope")
args <- commandArgs(TRUE)
start_date<-paste(args[1],args[2],sep=" ")
end_date<-paste(args[3],args[4],sep=" ")
sensor_box<-args[5]
sensor_type<-args[6]
colorPlot<-args[7]
typePlot<-args[8]
sensor_box2<-args[9]

#start_date<-"2017-02-20 18:10"
#end_date<-"2018-02-20 18:10"
#sensor_box<-4317218322204134
#sensor_box2<-4317218322204134
#typePlot<-"point"
#sensor_type<-"pm1.0"
#colorPlot<-"red"
.libPaths('C:/Users/florian.marques/Documents/R/win-library/3.5')#to indicate the path to the libraries when run the script through php
require('RPostgreSQL')
require('ggplot2')
require('ggmap')

con=dbConnect(PostgreSQL(),
              user="postgres",dbname="polluscope",password="12345678")
sqlStatement2 <-paste0("select name FROM unified_node where id='",sensor_box,"'"  )
out2 = dbGetQuery(con,sqlStatement2)
if (sensor_box2 != "NULL") {
sqlStatement3 <-paste0("select name FROM unified_node where id='",sensor_box2,"'"  )
out3 = dbGetQuery(con,sqlStatement3)
}

sqlStatement <- paste0("select * from flaten_all_data where node_id='", sensor_box ,"' and timestamp between '", start_date ,"' and '", end_date ,"'  ")
out=dbGetQuery(con, sqlStatement)
write.csv(out, file = "MyData.csv",row.names = FALSE)
png(filename="plot.png",width=500,height=500)# open or creat the png file

switch(typePlot,
point={
  if(sensor_type=="pm1.0")
    p<- ggplot(out, aes(out$timestamp, out$pm1.0, color='pm1.0'))
  if(sensor_type=="pm10")
    p<- ggplot(out, aes(out$timestamp, out$pm10, color='pm10'))
  if(sensor_type=="pm2.5")
    p<- ggplot(out, aes(out$timestamp, out$pm2.5, color='pm2.5'))
  if(sensor_type=="no2")
    p<- ggplot(out, aes(out$timestamp, out$no2, color='no2'))
  if(sensor_type=="bc")
    p<- ggplot(out, aes(out$timestamp, out$bc, color='bc'))
},
colonne={  
  if(sensor_type=="pm1.0")
    p<- ggplot(out, aes(out$timestamp, out$pm1.0, color='pm1.0')) + geom_bar(stat="identity")
  if(sensor_type=="pm10")
    p<- ggplot(out, aes(out$timestamp, out$pm10, color='pm10')) + geom_bar(stat="identity")
  if(sensor_type=="pm2.5")
    p<- ggplot(out, aes(out$timestamp, out$pm2.5, color='pm2.5')) + geom_bar(stat="identity")
  if(sensor_type=="no2")
    p<- ggplot(out, aes(out$timestamp, out$no2, color='no2')) + geom_bar(stat="identity")
  if(sensor_type=="bc")
    p<- ggplot(out, aes(out$timestamp, out$bc, color='bc')) + geom_bar(stat="identity")
},
courbe={
  if(sensor_type=="pm1.0")
    p<- ggplot(out, aes(out$timestamp, out$pm1.0, color='pm1.0')) + geom_line()
  if(sensor_type=="pm10")
    p<- ggplot(out, aes(out$timestamp, out$pm10, color='pm10')) + geom_line()
  if(sensor_type=="pm2.5")
    p<- ggplot(out, aes(out$timestamp, out$pm2.5, color='pm2.5')) + geom_line()
  if(sensor_type=="no2")
    p<- ggplot(out, aes(out$timestamp, out$no2, color='no2')) + geom_line()
  if(sensor_type=="bc")
    p<- ggplot(out, aes(out$timestamp, out$bc, color='bc')) + geom_line()
},
moyenne={
  if(sensor_type=="pm1.0")
    p<- ggplot(out, aes(out$timestamp, out$pm1.0, color='pm1.0')) + geom_smooth(model=lm)
  if(sensor_type=="pm10")
    p<- ggplot(out, aes(out$timestamp, out$pm10, color='pm10')) + geom_smooth(model=lm)
  if(sensor_type=="pm2.5")
    p<- ggplot(out, aes(out$timestamp, out$pm2.5, color='pm2.5')) + geom_smooth(model=lm)
  if(sensor_type=="no2")
    p<- ggplot(out, aes(out$timestamp, out$no2, color='no2')) + geom_smooth(model=lm)
  if(sensor_type=="bc")
    p<- ggplot(out, aes(out$timestamp, out$bc, color='bc')) + geom_smooth(model=lm)
},
{
  print('default')
}
)

p + geom_point(color=colorPlot)+ labs(x = "timestamp ", y=sensor_type ,title = out2$name)
dev.off()

if (sensor_box2 != "NULL") {
  sqlStatement <- paste0("select * from flaten_all_data where node_id='", sensor_box2 ,"' and timestamp between '", start_date ,"' and '", end_date ,"'  ")
  out2=dbGetQuery(con, sqlStatement)
  png(filename="plot2.png",width=500,height=500)# open or creat the png file
  switch(typePlot,
         point={
           if(sensor_type=="pm1.0")
             p<- ggplot(out2, aes(out2$timestamp, out2$pm1.0, color='pm1.0'))
           if(sensor_type=="pm10")
             p<- ggplot(out2, aes(out2$timestamp, out2$pm10, color='pm10'))
           if(sensor_type=="pm2.5")
             p<- ggplot(out2, aes(out2$timestamp, out2$pm2.5, color='pm2.5'))
           if(sensor_type=="no2")
             p<- ggplot(out2, aes(out2$timestamp, out2$no2, color='no2'))
           if(sensor_type=="bc")
             p<- ggplot(out2, aes(out2$timestamp, out2$bc, color='bc'))
         },
         colonne={  
           if(sensor_type=="pm1.0")
             p<- ggplot(out2, aes(out2$timestamp, out2$pm1.0, color='pm1.0')) + geom_bar(stat="identity")
           if(sensor_type=="pm10")
             p<- ggplot(out2, aes(out2$timestamp, out2$pm10, color='pm10')) + geom_bar(stat="identity")
           if(sensor_type=="pm2.5")
             p<- ggplot(out2, aes(out2$timestamp, out2$pm2.5, color='pm2.5')) + geom_bar(stat="identity")
           if(sensor_type=="no2")
             p<- ggplot(out2, aes(out2$timestamp, out2$no2, color='no2')) + geom_bar(stat="identity")
           if(sensor_type=="bc")
             p<- ggplot(out2, aes(out2$timestamp, out2$bc, color='bc')) + geom_bar(stat="identity")
         },
         courbe={
           if(sensor_type=="pm1.0")
             p<- ggplot(out2, aes(out2$timestamp, out2$pm1.0, color='pm1.0')) + geom_line()
           if(sensor_type=="pm10")
             p<- ggplot(out2, aes(out2$timestamp, out2$pm10, color='pm10')) + geom_line()
           if(sensor_type=="pm2.5")
             p<- ggplot(out2, aes(out2$timestamp, out2$pm2.5, color='pm2.5')) + geom_line()
           if(sensor_type=="no2")
             p<- ggplot(out2, aes(out2$timestamp, out2$no2, color='no2')) + geom_line()
           if(sensor_type=="bc")
             p<- ggplot(out2, aes(out2$timestamp, out2$bc, color='bc')) + geom_line()
         },
         moyenne={
           if(sensor_type=="pm1.0")
             p<- ggplot(out2, aes(out2$timestamp, out2$pm1.0, color='pm1.0')) + geom_smooth(model=lm)
           if(sensor_type=="pm10")
             p<- ggplot(out2, aes(out2$timestamp, out2$pm10, color='pm10')) + geom_smooth(model=lm)
           if(sensor_type=="pm2.5")
             p<- ggplot(out2, aes(out2$timestamp, out2$pm2.5, color='pm2.5')) + geom_smooth(model=lm)
           if(sensor_type=="no2")
             p<- ggplot(out2, aes(out2$timestamp, out2$no2, color='no2')) + geom_smooth(model=lm)
           if(sensor_type=="bc")
             p<- ggplot(out2, aes(out2$timestamp, out2$bc, color='bc')) + geom_smooth(model=lm)
         },
         {
           print('default')
         }
  )
  p + geom_point(color=colorPlot)+ labs(x = "timestamp ", y=sensor_type ,title = out3$name)
}

dev.off()
register_google(key = "AIzaSyBd4BvkehJr6z4Umr9yh83WY4C2FC0XwXk")
png(filename="map.png",width=500,height=500)# opening or creating the png file
lx_map <- get_map(location = c(2.3272305000000415 ,48.8635517), maptype = "roadmap", zoom = 12)
if (sensor_box2 != "NULL") {
  ggmap(lx_map, extent = "device")+ geom_point(data=out, aes(x=out$gps_lng, y=out$gps_lat),size=4, color=colorPlot) + geom_point(data=out2, aes(x=out2$gps_lng, y=out2$gps_lat),size=4, color="purple")
}
if (sensor_box2 == "NULL") {
  ggmap(lx_map, extent = "device")+ geom_point(data=out, aes(x=out$gps_lng, y=out$gps_lat),size=4, color=colorPlot)
}
dev.off()

dbDisconnect(con)

