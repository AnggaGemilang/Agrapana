import pickle
import numpy
from . import SingeltonMeta

class CropRecommendation(SingeltonMeta.SingletonMeta):
  
  def __init__(self):
    self._model = pickle.load(open('src\service\pickle_model\crop_recommend.sav','rb'))
    self._label = numpy.load('src\service\pickle_model\crop_label_encoder.npy',allow_pickle=True)
    
  def predict(self,data):
    pred = self._model.predict([data])

    return self._label[pred[0]]
  
  def get_label(self):
    return self._label