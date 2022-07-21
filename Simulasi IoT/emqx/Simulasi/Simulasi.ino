#include <PubSubClient.h>
#include <ArduinoJson.h>
#include <ESP8266WiFi.h>

#define MSG_BUFFER_SIZE (50)
#define LEDPin D1
#define LightSensorPin A0
#define ssid "JTK Dosen"
#define password "jaringan"
#define mqtt_broker "broker.emqx.io"
#define mqtt_username "emqx"
#define mqtt_password "public"
#define mqtt_port 1883

WiFiClient wifiClient;
PubSubClient mqttClient(wifiClient);

unsigned long lastMsg = 0;
char msg[MSG_BUFFER_SIZE];
int value = 0;
char led[25] = "";
char output[200];

void callback(char *topic, byte *payload, unsigned int length) {
  Serial.print("Message arrived [");
  Serial.print(topic);
  Serial.print("] ");  
  
  StaticJsonDocument<128> doc;
  deserializeJson(doc, payload, length);
  strlcpy(led, doc["configuration"]["led"] | "default", sizeof(led));
  Serial.print(led);
  Serial.println();
  digitalWrite(LEDPin, HIGH);
//  if (!strcmp(led, "on")) {
//    digitalWrite(LEDPin, HIGH);
//  } 
//  if (!strcmp(led, "off")) {
//    digitalWrite(LEDPin, LOW);
//  }
}

void setup() {

  Serial.begin(115200);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.println("Connecting to WiFi..");
  }
  Serial.println("Connected to the WiFi network!");

  mqttClient.setServer(mqtt_broker, mqtt_port);
  mqttClient.setCallback(callback);
  while (!mqttClient.connected()) {
    String client_id = String(WiFi.macAddress());
 
    if (mqttClient.connect(client_id.c_str(), mqtt_username, mqtt_password)) {
      Serial.println("Connected to Public MQTT Broker");
    } else {
      Serial.print("Failed to connect with MQTT Broker");
      Serial.print(mqttClient.state());
      delay(2000);
    }
  }
  mqttClient.subscribe("arceniter");
}

void loop() {
  mqttClient.loop();

  unsigned long now = millis();
  if (now - lastMsg > 2000) {
    int lightData = analogRead(LightSensorPin);
    
    lastMsg = now;
    ++value;
    snprintf (msg, MSG_BUFFER_SIZE, "%ld", lightData);

    StaticJsonDocument<96> doc;

    doc["configuration"]["led"] = led;
    doc["monitoring"]["light"] = msg;
    
    serializeJson(doc, output); 
       
    Serial.print("Publish message: ");
    Serial.println(output);
    mqttClient.publish("arceniter", output);
  }

}
