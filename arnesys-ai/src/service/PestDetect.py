import pickle
import numpy
from . import SingeltonMeta

class PestDetect(SingeltonMeta.SingletonMeta):
  
  def __init__(self):
    self._thripidae_model = pickle.load(open('src\service\pickle_model\thripidae_detect.sav','rb'))
    
  def predict(self,data):
    pred = self._thripidae_model.predict([data])
    if pred[0] == 0:
      return 'Tidak Ada'
    if pred[0] == 1:
      return 'Rendah'
    if pred[0] == 2:
      return 'Sedang'
    if pred[0] == 3:
      return 'Tinggi'