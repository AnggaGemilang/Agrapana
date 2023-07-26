#include <PubSubClient.h>
#include <ArduinoJson.h>
#include <WiFi.h>
#include <HTTPClient.h>

#define MSG_BUFFER_SIZE (50)
#define MQTT_SERVER "test.mosquitto.org"
#define MQTT_PORT 1883
#define WIFI_SSID "SPEEDY"
#define WIFI_PASSWORD "suherman"
//#define WIFI_SSID "kostankuning@wifi.id"
//#define WIFI_PASSWORD "kostankuning14"

HTTPClient httpMainDevice, httpSupportDevice;
WiFiClient espClient;
PubSubClient client(espClient);

char CLIENT_CODE[50] = "d02557b0-c0fa-415e-924c-ac624a691c0d";
char FIELD_CODE[50] = "cd3eb1ad-f3ee-4fa4-bf19-0e4f7da89746";
char SERVER1[58] = "https://arnesys.agrapana.tech/api/monitoring-main-devices";
char SERVER2[61] = "https://arnesys.agrapana.tech/api/monitoring-support-devices";
char topic[100] = "";
long lastMsg = 0;
long lastMsg2 = 0;

char output[200];
unsigned int windTemperature, windHumidity, windPressure, windSpeed, lightIntensity;
unsigned int soilTemperature, soilHumidity, soilPh, soilNitrogen, soilPhosphor, soilKalium;
boolean rainfall;

void setup_wifi() {
  Serial.print("Connecting to ");
  Serial.print(WIFI_SSID);
  Serial.println();

  WiFi.mode(WIFI_STA);
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  randomSeed(micros());

  Serial.println("");
  Serial.println("WiFi connected");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
}

void reconnect() {
  while (!client.connected()) {
    Serial.print("Attempting MQTT connection...");
    String clientId = "ESP32Client-";
    clientId += String(random(0xffff), HEX);
    if (client.connect(clientId.c_str())) {
      Serial.println("connected");
    } else {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds");
      delay(5000);
    }
  }
}

void setup() {
  Serial.begin(9600);
  setup_wifi();
  client.setServer(MQTT_SERVER, MQTT_PORT);
}

void loop() {
  if (!client.connected()) {
    reconnect();
  }
  client.loop();

  unsigned long now = millis();

  if (now - lastMsg > 4000) {
    
    lastMsg = now;

    Serial.println("");

//    Kirim data perangkat utama

    StaticJsonDocument<96> doc;

    windTemperature = random(25, 28);
    windHumidity = random(40, 43);
    windPressure = random(13, 15); 
    windSpeed = random(6, 9);       
    rainfall = random(0, 1);
    lightIntensity = random(2800, 3200);

    doc["monitoring"]["wind_temperature"] = windTemperature;
    doc["monitoring"]["wind_humidity"] = windHumidity;
    doc["monitoring"]["wind_pressure"] = windPressure;
    doc["monitoring"]["wind_speed"] = windSpeed;
    doc["monitoring"]["rainfall"] = rainfall;
    doc["monitoring"]["light_intensity"] = lightIntensity;
    serializeJson(doc, output); 

    strcpy(topic, "arnesys/");
    strcat(topic, CLIENT_CODE);
    strcat(topic, "/");
    strcat(topic, FIELD_CODE);
    strcat(topic, "/utama");
    Serial.print("Topic: ");
    Serial.println(topic);
    
    client.publish(topic, output);
    Serial.print("Publish message: ");
    Serial.println(output);

//    Kirim data perangkat pendukung

    Serial.println("");

    StaticJsonDocument<200> doc2;

    soilTemperature = random(25, 28);
    soilHumidity = random(40, 43);
    soilPh = random(5, 7);
    soilNitrogen = random(8, 9);
    soilPhosphor = random(2, 3);
    soilKalium = random(5, 6);

    doc2["monitoring"]["soil_temperature"] = soilTemperature;
    doc2["monitoring"]["soil_humidity"] = soilHumidity;
    doc2["monitoring"]["soil_ph"] = soilPh;
    doc2["monitoring"]["soil_nitrogen"] = soilNitrogen;
    doc2["monitoring"]["soil_phosphor"] = soilPhosphor;
    doc2["monitoring"]["soil_kalium"] = soilKalium;
    serializeJson(doc2, output); 

    strcpy(topic, "arnesys/");
    strcat(topic, CLIENT_CODE);
    strcat(topic, "/");
    strcat(topic, FIELD_CODE);
    strcat(topic, "/pendukung/1");
    Serial.print("Topic: ");
    Serial.println(topic);
    
    client.publish(topic, output);
    Serial.print("Publish message: ");
    Serial.println(output);

    Serial.println("");
    Serial.println("=====================================");
    
  }

  if (now - lastMsg2 > 10000) {
    
    lastMsg2 = now;

    Serial.println("");

//    Kirim data perangkat utama

    httpMainDevice.begin(SERVER1);

    httpMainDevice.addHeader("Content-Type", "application/x-www-form-urlencoded");
    String httpRequestData = "&wind_temperature=" + String(windTemperature) + "&wind_humidity=" + String(windHumidity) + "&wind_pressure=" + String(windPressure) + "&wind_speed=" + String(windSpeed) + "&rainfall=" + String(rainfall) + "&light_intensity=" + String(lightIntensity) + "&field_id=" + String(FIELD_CODE);
    int httpResponseCode = httpMainDevice.POST(httpRequestData);
           
    Serial.print("HTTP Response code is: ");
    Serial.println(httpResponseCode);
    httpMainDevice.end();

//    Kirim data perangkat pendukung

    Serial.println("");

    httpSupportDevice.begin(SERVER2);

    httpSupportDevice.addHeader("Content-Type", "application/x-www-form-urlencoded");
    String httpRequestData2 = "&number_of=1&soil_temperature=" + String(soilTemperature) + "&soil_humidity=" + String(soilHumidity) + "&soil_ph=" + String(soilPh) + "&soil_nitrogen=" + String(soilNitrogen) + "&soil_phosphor=" + String(soilPhosphor) + "&soil_kalium=" + String(soilKalium) + "&field_id=" + String(FIELD_CODE);
    int httpResponseCode2 = httpSupportDevice.POST(httpRequestData2);
    
    Serial.print("HTTP Response code is: ");
    Serial.println(httpResponseCode2);
    httpSupportDevice.end();

    Serial.println("");
    Serial.println("=====================================");
    
  }
  
}
