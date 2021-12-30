// Import de pacotes
import React from 'react';
import { createStackNavigator, TransitionPresets } from '@react-navigation/stack';

// Import de tema
import theme from '../global/styles/theme';

// Páginas que a Empresa/o técnico pode acessar
import { Home } from '../pages/Home';
import { Agenda } from '../pages/Agenda';
import { EditPassword } from '../pages/EditPassword';
import { Plans } from '../pages/Plans';
import { FinishedOSClient } from '../pages/Services/finishedOSClient';
import { FollowServices } from '../pages/Services/follow';
import { Request } from '../pages/Services/request';
import { RequestServices } from '../pages/Services/list';
import { SelectedService } from '../pages/Services/selected';
import { ShoppingCart } from '../pages/ShoppingCart';
import { ShowServices } from '../pages/Services/show';
import { UserTerms } from '../pages/UserTerms';
import { YourRequests } from '../pages/Services/yourRequest';
import { Profile } from '../pages/Profile';
import { EditProfile } from '../pages/EditProfile';

const Auth = createStackNavigator();

const UserRoutes: React.FC = () => (
    <Auth.Navigator
        screenOptions={{
            headerShown: false,
            cardStyle: { backgroundColor: theme.colors.contrast },
            ...TransitionPresets.SlideFromRightIOS,
        }}
    >
        <Auth.Screen name="Home" component={Home} />
        <Auth.Screen name="Agenda" component={Agenda} />
        <Auth.Screen name="Profile" component={Profile} />
        <Auth.Screen name="EditProfile" component={EditProfile} />
        <Auth.Screen name="EditPassword" component={EditPassword} />
        <Auth.Screen name="Plans" component={Plans} />
        
        <Auth.Screen name="FinishedOSClient" component={FinishedOSClient} />
        <Auth.Screen name="FollowServices" component={FollowServices} />
        <Auth.Screen name="Request" component={Request} />
        <Auth.Screen name="RequestServices" component={RequestServices} />
        <Auth.Screen name="SelectedService" component={SelectedService} />
        <Auth.Screen name="ShoppingCart" component={ShoppingCart} />
        <Auth.Screen name="ShowServices" component={ShowServices} />
        <Auth.Screen name="UserTerms" component={UserTerms} />
        <Auth.Screen name="YourRequests" component={YourRequests} />
    </Auth.Navigator>
);

export default UserRoutes;

/* 
AdmHome            X     //Página inicial do adm
AdmMetrics         X     //Página de parâmetros do adm
InOrder            X     //Usado para páginas em construção

// Carrega o visual com comentários em partes do código
ClientRegister     X     //Registro de cliente
EmpresaRegister    X     //Registro de técnico
EditProfile        O     //Mudar informações do perfil
Login              X     //Login
 */