#include <PubSubClient.h>
#include <ArduinoJson.h>
#include <WiFi.h>
#include <HTTPClient.h>

#define MSG_BUFFER_SIZE (50)
#define WIFI_SSID "SPEEDY"
#define WIFI_PASSWORD "suherman"
#define MQTT_SERVER "test.mosquitto.org"
#define CLIENT_CODE "client_123"
#define FIELD_CODE "field_123"

HTTPClient http;
WiFiClient espClient;
PubSubClient client(espClient);

const char* server = "http://api.thingspeak.com/update";

unsigned long lastMsg = 0;
char msg[MSG_BUFFER_SIZE];
char led[25] = "";
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
  Serial.println("IP address: ");
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

    StaticJsonDocument<96> doc;

    doc["configuration"]["led"] = led;
    doc["monitoring"]["light"] = msg;
    
    serializeJson(doc, output); 
       
    Serial.print("Publish message: ");
    Serial.println(output);
    client.publish("arnesys", output);

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
