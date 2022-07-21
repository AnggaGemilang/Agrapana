#include <PubSubClient.h>
#include <ArduinoJson.h>
#include <ESP8266WiFi.h>

#define MSG_BUFFER_SIZE (50)
#define LEDPin D1
#define LightSensorPin A0
#define WIFI_SSID "angga"
#define WIFI_PASSWORD "anggaganteng"
#define MQTT_SERVER "test.mosquitto.org"

WiFiClient espClient;
PubSubClient client(espClient);

unsigned long lastMsg = 0;
char msg[MSG_BUFFER_SIZE];
int value = 0;

void setup_wifi() {
  delay(10);  
  Serial.print("Connecting to ");
  Serial.println(WIFI_SSID);

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

void callback(char* topic, byte* payload, unsigned int length) {
  Serial.print("Message arrived [");
  Serial.print(topic);
  Serial.print("] ");
  for (int i = 0; i < length; i++) {
    Serial.print((char)payload[i]);
  }
  Serial.println();
  if ((char)payload[0] == '0') {
    digitalWrite(LEDPin, LOW);
  } 
  if ((char)payload[0] == '1') {
    digitalWrite(LEDPin, HIGH);
  }
}

void reconnect() {
  while (!client.connected()) {
    Serial.print("Attempting MQTT connection...");
    String clientId = "ESP8266Client-";
    clientId += String(random(0xffff), HEX);
    if (client.connect(clientId.c_str())) {
      Serial.println("connected");
      client.publish("arceniter", "started light sensor");
      client.publish("arceniter", "started LED");
      client.subscribe("arceniter");
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

  Serial.println("Hello World");

  pinMode(LEDPin, OUTPUT);
  pinMode(LightSensorPin, INPUT);
  
  setup_wifi();

  client.setServer(MQTT_SERVER, 1883);
  client.setCallback(callback);
}

void loop() {
  if (!client.connected()) {
    reconnect();
  }
  client.loop();

  unsigned long now = millis();
  if (now - lastMsg > 2000) {
    int lightData = analogRead(LightSensorPin);
    
    lastMsg = now;
    ++value;
    snprintf (msg, MSG_BUFFER_SIZE, "value #%ld", lightData);
    Serial.print("Publish message: ");
    Serial.println(msg);
    client.publish("arceniter", msg);
  }
}
