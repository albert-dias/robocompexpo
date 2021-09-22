// Import de pacotes
import React, { useEffect, useRef, useState } from 'react';
import { Image, TouchableNativeFeedback, View } from 'react-native';
import { animated, useSpring } from 'react-spring';
import * as easings from 'd3-ease';

// Import de páginas
import PanelSlider from '../../components/PanelSlider2';
import { DIMENSIONS_HEIGHT, DIMENSIONS_WIDTH } from '../../components/Screen';
import { PanelTitle } from '../../components/GlobalCSS';

// Import de imagens
import logo from '../../../assets/images/logo_branca_robocomp.png';