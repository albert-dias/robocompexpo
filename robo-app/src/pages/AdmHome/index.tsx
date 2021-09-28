// Import de pacotes
import React, { useEffect, useState } from 'react';
import { Image, ImageBackground, StyleSheet, View } from 'react-native';
import { Text } from 'react-native-paper';
import { ScrollView, TouchableOpacity } from 'react-native-gesture-handler';
import { FontAwesome5 } from '@expo/vector-icons';

// Import de páginas
import Container, { ContainerTop } from '../../components/Container';
import { Input } from '../../components/GlobalCSS';
import theme from '../../global/styles/theme';
import storage from '../../util/storage';

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';

export function AdmHome() {
    // Variáveis
    const [list, setList] = useState(['']);
    const [filter, setFilter] = useState(false);
    const [name, setName] = useState('');

    // Construção da página
    return (
        <View style={{ flexGrow: 1 }}>
            <ContainerTop>
                <ImageBackground
                    source={imgBanner}
                    style={{
                        width: '100%',
                        justifyContent: 'center',
                        alignItems: 'center'
                    }}>
                    <Container pb
                        style={{
                            flexDirection: 'column',
                            alignItems: 'center',
                            justifyContent: 'center',
                            width: '100%'
                        }}>
                        <Image
                            source={logo}
                            resizeMode='contain'
                            style={{
                                width: 170,
                                height: 170,
                                marginTop: '-8%',
                                marginBottom: '-13%'
                            }} />
                        <Text style={styles.textStyleF}>
                            Robocomp - Administração de Cadastros
                        </Text>
                        <TouchableOpacity
                            style={{
                                alignSelf: 'flex-start',
                                alignContent: 'flex-start',
                                alignItems: 'flex-start'
                            }}
                            onPress={async () => { console.log('Fazer logoff') }}
                        >
                            <FontAwesome5
                                name='power-off'
                                color={theme.colors.white}
                                size={40}
                            />
                        </TouchableOpacity>
                    </Container>
                </ImageBackground>
            </ContainerTop>
            <View style={{
                flexDirection: 'row',
                alignItems: 'center',
                alignSelf: 'center',
                backgroundColor: '#F4F1F0',
                width: '100%',
                justifyContent: 'center',
                height: '8%',
            }}>
                <Text style={{ marginHorizontal: 10, marginTop: 5 }}>EmpresaTI</Text>
                {(filter) ?
                    <TouchableOpacity
                        style={styles.anuncioIcon}
                        onPress={() => { setFilter(!filter) }}
                    >
                        <FontAwesome5
                            name='toggle-on'
                            color={theme.colors.green}
                            size={40}
                        />
                    </TouchableOpacity>
                    :
                    <TouchableOpacity
                        style={styles.anuncioIcon}
                        onPress={() => { setFilter(!filter) }}
                    >
                        <FontAwesome5
                            name='toggle-off'
                            color={theme.colors.darkGray}
                            size={40}
                        />
                    </TouchableOpacity>
                }
                <Text style={{ marginHorizontal: 10, marginTop: 5 }}>Clientes</Text>
            </View>
            <View style={{ flexDirection: 'row', alignItems: 'center', backgroundColor: '#F4F1F0', justifyContent: 'center' }}>
                <TouchableOpacity onPress={() => console.log('navegar para métricas')}>
                    <FontAwesome5
                        name='street-view'
                        color={theme.colors.contrast}
                        size={40}
                    />
                </TouchableOpacity>
                <Input
                    style={{ width: '50%', marginHorizontal: 15 }}
                    mode='flat'
                    onSubmitEditing={() => { console.log('Pesquisar usuários') }}
                    onChangeText={(text) => setName(text)}
                    value={name}
                />
                <TouchableOpacity onPress={() => { console.log('Pesquisar usuários') }}>
                    <FontAwesome5
                        name='search'
                        color={theme.colors.contrast}
                        size={40}
                    />
                </TouchableOpacity>
            </View>

            <ScrollView style={styles.scrollView}>
                <View style={styles.viewn}>
                    {(list !== undefined) ? list.map((listening) =>
                        <View style={styles.anuncioCard} key={listening.id}>
                            <Text style={{ maxWidth: '80%' }}>{listening.name}</Text>
                            {(listening.active === true) ?
                                <TouchableOpacity
                                    style={styles.anuncioIcon}
                                    onPress={() => { }}
                                >
                                    <FontAwesome5
                                        name='toggle-on'
                                        color={theme.colors.green}
                                        size={40}
                                    />
                                </TouchableOpacity>
                                :
                                <TouchableOpacity
                                    style={styles.anuncioIcon}
                                    onPress={() => { }}
                                >
                                    <FontAwesome5
                                        name='toggle-off'
                                        color={theme.colors.darkGray}
                                        size={40}
                                    />
                                </TouchableOpacity>
                            }
                        </View>) : <View />}
                </View>
            </ScrollView>
        </View>
    );

};
const styles = StyleSheet.create({
    container: {
        flex: 1,
    },
    scrollView: {
        flexGrow: 1,
        backgroundColor: '#F4F1F0',
        height: '68%',
    },
    textStyleF: {
        fontSize: 16,
        paddingLeft: 20,
        paddingRight: 20,
        color: 'white',
        textAlign: 'center',
        padding: 3,
    },
    viewn: {
        height: 'auto',
        justifyContent: 'space-around',
        margin: 10,
        padding: 20,
    },
    anuncioCard: {
        flexDirection: 'row',
        minHeight: 50,
        width: '90%',
        marginHorizontal: '5%',
        marginVertical: '1%',
        borderRadius: 8,
        borderWidth: 1,
        borderColor: 'black',
        alignItems: 'center',
        justifyContent: 'space-between',
        paddingHorizontal: '2%',
    },
    anuncioIcon: {
        flex: 1,
        marginHorizontal: 5,
        justifyContent: 'center'
    },
});