// Import de pacotes
import React from 'react';
import { createStackNavigator, TransitionPresets } from '@react-navigation/stack';

// Import de tema
import theme from '../global/styles/theme';

// Páginas que a Empresa/o técnico pode acessar
import { Home } from '../pages/EmpresaTIHome';
import { Agenda } from '../pages/Agenda';
import { EditPassword } from '../pages/EditPassword';
import { Plans } from '../pages/Plans';
import { YourServices } from '../pages/Services/yourServices';
import { AcceptServices } from '../pages/Services/accept';
import { AddService } from '../pages/Services/add';
import { EditService } from '../pages/Services/edit';
import { FinishedOS } from '../pages/Services/finishedOS';
import { History } from '../pages/Services/history';
import { InProgress } from '../pages/InProgress';
import { SearchService } from '../pages/Services/search';
import { TrackServices } from '../pages/Services/status';
import { UserTerms } from '../pages/UserTerms';
import { Profile } from '../pages/Profile';
import { EditProfile } from '../pages/EditProfile';

const Auth = createStackNavigator();

const EmpresaRoutes: React.FC = () => (
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

        <Auth.Screen name="AcceptServices" component={AcceptServices} />
        <Auth.Screen name="AddServices" component={AddService} />
        <Auth.Screen name="YourServices" component={YourServices} />
        <Auth.Screen name="EditServices" component={EditService} />
        <Auth.Screen name="FinishedOS" component={FinishedOS} />
        <Auth.Screen name="History" component={History} />
        <Auth.Screen name="InProgress" component={InProgress} />
        <Auth.Screen name="SearchServices" component={SearchService} />
        <Auth.Screen name="TrackServices" component={TrackServices} />
        <Auth.Screen name="UserTerms" component={UserTerms} />
        
    </Auth.Navigator>
);

export default EmpresaRoutes;