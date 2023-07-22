#include <PubSubClient.h>
#include <ArduinoJson.h>
#include <WiFi.h>
#include <HTTPClient.h>

#define MSG_BUFFER_SIZE (50)
#define WIFI_SSID "SPEEDY"
#define WIFI_PASSWORD "suherman"
#define MQTT_SERVER "test.mosquitto.org"

HTTPClient http;
WiFiClient espClient;
PubSubClient client(espClient);

char CLIENT_CODE[50] = "client_123/";
char FIELD_CODE[50] = "field_123/";
char SERVER[50] = "http://api.thingspeak.com/update";
char topic[100] = "";
long lastMsg = 0;

char output[200];

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
  StaticJsonDocument<128> doc;
  setup_wifi();
  client.setServer(MQTT_SERVER, 1883);
}

void loop() {
  if (!client.connected()) {
    reconnect();
  }
  client.loop();

  unsigned long now = millis();
  if (now - lastMsg > 2000) {
    
    lastMsg = now;

//    Kirim data perangkat utama

    StaticJsonDocument<96> doc;

    doc["monitoring"]["dadang1"] = random(0, 100);
    doc["monitoring"]["dadang2"] = random(0, 100);
    doc["monitoring"]["dadang3"] = random(0, 100);
    doc["monitoring"]["dadang4"] = random(0, 100);
    doc["monitoring"]["dadang5"] = random(0, 100);
    serializeJson(doc, output); 

    strcpy(topic, "arnesys/");
    strcat(topic, CLIENT_CODE);
    strcat(topic, FIELD_CODE);
    strcat(topic, "utama");
    Serial.print("Topic: ");
    Serial.println(topic);
    
    client.publish(topic, output);
    Serial.print("Publish message: ");
    Serial.println(output);

//    Kirim data perangkat pendukung

    doc["monitoring"]["warko1"] = random(0, 100);
    doc["monitoring"]["warko2"] = random(0, 100);
    doc["monitoring"]["warko3"] = random(0, 100);
    doc["monitoring"]["warko4"] = random(0, 100);
    doc["monitoring"]["warko5"] = random(0, 100);
    serializeJson(doc, output); 

    strcpy(topic, "arnesys/");
    strcat(topic, CLIENT_CODE);
    strcat(topic, FIELD_CODE);
    strcat(topic, "pendukung/1");
    Serial.print("Topic: ");
    Serial.println(topic);
    
    client.publish(topic, output);
    Serial.print("Publish message: ");
    Serial.println(output);


//    http.begin(server);
//
//    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
//    String httpRequestData = "&field1=" + String(random(50));           
//    int httpResponseCode = http.POST(httpRequestData);
//           
//    Serial.print("HTTP Response code is: ");
//    Serial.println(httpResponseCode);
//    http.end();
    
  }
}
