#include <Fuzzy.h>

Fuzzy *fuzzy = new Fuzzy();

// FuzzySet Input Suhu
FuzzySet *suhuDingin = new FuzzySet(-10, 0, 13.5, 27);
FuzzySet *suhuNormal = new FuzzySet(25, 28, 31);
FuzzySet *suhuPanas = new FuzzySet(29, 34.5, 40, 100);

// FuzzySet Input Kecepatan Udara
FuzzySet *kecepatanPelan = new FuzzySet(-4, 0, 2, 4);
FuzzySet *kecepatanSedang = new FuzzySet(2, 5, 8);
FuzzySet *kecepatanKencang = new FuzzySet(6, 8, 10, 20);

// FuzzySet Input Kelembaban
FuzzySet *kelembabanKering = new FuzzySet(50, 70, 75, 80);
FuzzySet *kelembabanSedang = new FuzzySet(75, 82.5, 90);
FuzzySet *kelembabanBasah = new FuzzySet(85, 90, 95, 100);

// FuzzySet Output Prediksi Cuaca
FuzzySet *cerahBerawan = new FuzzySet(-5, 0, 2.5, 5);
FuzzySet *hujanRingan = new FuzzySet(2.5, 11.25, 20);
FuzzySet *hujanSedang = new FuzzySet(15, 32.5, 50);
FuzzySet *hujanLebat = new FuzzySet(45, 72.5, 100, 120);

void setup()
{
  Serial.begin(9600);
  randomSeed(analogRead(0));
     
  // FuzzyInput suhu
  FuzzyInput *temperature = new FuzzyInput(1);
  temperature->addFuzzySet(suhuDingin);
  temperature->addFuzzySet(suhuNormal);
  temperature->addFuzzySet(suhuPanas);
  fuzzy->addFuzzyInput(temperature);
    
  // FuzzyInput kecepatan angin
  FuzzyInput *windSpeed = new FuzzyInput(2);
  windSpeed->addFuzzySet(kecepatanPelan);
  windSpeed->addFuzzySet(kecepatanSedang);
  windSpeed->addFuzzySet(kecepatanKencang);
  fuzzy->addFuzzyInput(windSpeed);
    
  // FuzzyInput kelembaban
  FuzzyInput *humidity = new FuzzyInput(4);
  humidity->addFuzzySet(kelembabanKering);
  humidity->addFuzzySet(kelembabanSedang);
  humidity->addFuzzySet(kelembabanBasah);
  fuzzy->addFuzzyInput(humidity);

//===================================================

  // FuzzyOutput kondisi cuaca
  FuzzyOutput *prediksiCuaca = new FuzzyOutput(1);
  prediksiCuaca->addFuzzySet(cerahBerawan);
  prediksiCuaca->addFuzzySet(hujanRingan);
  prediksiCuaca->addFuzzySet(hujanSedang);
  prediksiCuaca->addFuzzySet(hujanLebat);
  fuzzy->addFuzzyOutput(prediksiCuaca);

//===================================================

  FuzzyRuleAntecedent *ifDistanceSmall = new FuzzyRuleAntecedent();
  ifDistanceSmall->joinSingle(small);
  FuzzyRuleConsequent *thenSpeedSlow = new FuzzyRuleConsequent();
  thenSpeedSlow->addOutput(slow);
  FuzzyRule *fuzzyRule01 = new FuzzyRule(1, ifDistanceSmall, thenSpeedSlow);
  fuzzy->addFuzzyRule(fuzzyRule01);

  FuzzyRuleAntecedent *ifDistanceSafe = new FuzzyRuleAntecedent();
  ifDistanceSafe->joinSingle(safe);
  FuzzyRuleConsequent *thenSpeedAverage = new FuzzyRuleConsequent();
  thenSpeedAverage->addOutput(average);
  FuzzyRule *fuzzyRule02 = new FuzzyRule(2, ifDistanceSafe, thenSpeedAverage);
  fuzzy->addFuzzyRule(fuzzyRule02);

  FuzzyRuleAntecedent *ifDistanceBig = new FuzzyRuleAntecedent();
  ifDistanceBig->joinSingle(big);
  FuzzyRuleConsequent *thenSpeedFast = new FuzzyRuleConsequent();
  thenSpeedFast->addOutput(fast);
  FuzzyRule *fuzzyRule03 = new FuzzyRule(3, ifDistanceBig, thenSpeedFast);
  fuzzy->addFuzzyRule(fuzzyRule03);
}

void loop()
{
  int input1 = random(0, 80);
  int input2 = random(0, 80);
  int input3 = random(0, 80);

  fuzzy->setInput(1, input1);
  fuzzy->setInput(2, input2);
  fuzzy->setInput(3, input3);
  fuzzy->fuzzify();
  float output = fuzzy->defuzzify(1);
  Serial.println("Result: ");
  Serial.println(output);

  delay(12000);
}
