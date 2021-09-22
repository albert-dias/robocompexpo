// Import de pacotes
import React, { useEffect, useRef, useState } from 'react';
import { Image, TouchableNativeFeedback, View } from 'react-native';
import { animated, useSpring } from 'react-spring';
import * as easings from 'd3-ease';

// Import de páginas
import PanelSlider from '../../components/PanelSlider2';
import { DIMENSIONS_HEIGHT, DIMENSIONS_WIDTH } from '../../components/Screen';
import { PanelTitle } from '../../components/GlobalCSS';
import { Input } from '../../components/GlobalCSS';
import theme from '../../global/styles/theme';

// Import de imagens
import logo from '../../../assets/images/logo_branca_robocomp.png';

export function Login() {
    return (
        <View>
            <Input
                mode='flat'
                label='Nome completo'
                value='TESTE'
                onChangeText={() => { }}
            />
        </View>
    );
}