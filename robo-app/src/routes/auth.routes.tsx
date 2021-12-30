import React from 'react';
import { createStackNavigator, TransitionPresets } from '@react-navigation/stack';

import theme from '../global/styles/theme';
import { Intro } from '../Intro';
import { Login } from '../pages/Login';
import { ClientRegister } from '../pages/ClientRegister/Cadastro';
import { EmpresaRegister } from '../pages/EmpresaRegister/Cadastro';
import { SelecionarPerfil } from '../pages/SelecionarPerfil';

import { AdmHome } from '../pages/AdmHome';
import { AdmMetrics } from '../pages/AdmHome/AdmMetrics';

import { Home } from '../pages/Home';
import { Home as EmpresaTIHome } from '../pages/EmpresaTIHome';

const Auth = createStackNavigator();

const AuthRoutes: React.FC = () => (
    <Auth.Navigator
        screenOptions={{
            headerShown: false,
            cardStyle: { backgroundColor: theme.colors.contrast },
            ...TransitionPresets.SlideFromRightIOS,
        }}
    >
        <Auth.Screen name="Intro" component={Intro} />
        <Auth.Screen name="Login" component={Login} />
        <Auth.Screen name="ClientRegister" component={ClientRegister} />
        <Auth.Screen name="EmpresaRegister" component={EmpresaRegister} />
        <Auth.Screen name="SelecionarPerfil" component={SelecionarPerfil}/>

        {/* <Auth.Screen name="AdmHome" component={AdmHome}/>
        <Auth.Screen name="AdmMetrics" component={AdmMetrics}/>
        <Auth.Screen name="EmpresaTIHome" component={EmpresaTIHome}/>
        <Auth.Screen name="Home" component={Home}/> */}

    </Auth.Navigator>
);

export default AuthRoutes;