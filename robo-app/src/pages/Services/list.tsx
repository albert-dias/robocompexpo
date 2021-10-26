// Import de de pacotes
import React, { useCallback, useEffect, useState } from 'react';
import {
    Alert,
    Image,
    ImageBackground,
    Platform,
    ScrollView,
    StyleSheet,
    TouchableOpacity,
    View
} from 'react-native';
import { Dialog, Portal, RadioButton, Text, TextInput } from 'react-native-paper';
import { TouchableWithoutFeedback } from 'react-native-gesture-handler';
import { Fontisto, FontAwesome5 } from '@expo/vector-icons';
import DateTimePicker from '@react-native-community/datetimepicker';

// Import de páginas
import Container, { ContainerTop } from '../../components/Container';
import { Input } from '../../components/GlobalCSS';
import theme from "../../global/styles/theme";

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';
import imgTeste from '../../../assets/images/jetpack_logo.png';     //Imagem de teste

export function RequestServices() {
    // Variáveis
    const [search, setSearch] = useState('serviços');
    const [text, setText] = useState('');
    const [text2, setText2] = useState('');

    const [show, setShow] = useState(true);                                     //Mostrar/Ocultar categorias - true esconde, false mostra
    const [show2, setShow2] = useState([]);                                     //Mostrar/Ocultar filtros - true esconde, false mostra
    const [show3, setShow3] = useState(true);                                   //Selecionar categoria

    const [filtro, setFiltro] = useState('');                                   //Recebe o nome do filtro aplicado

    const [showDate, setShowDate] = useState(false);                            //Abre o <Portal> para selecionar uma data
    const [hour, setHour] = useState(false);                                    //Avança a opção de data para hora
    const [day, setDay] = useState(false);                                      //Abre o <DateTimePicker> da data
    const [period, setPeriod] = useState(false);                                //Abre o <DateTimePicker> da hora
    const [horaStart, setHoraStart] = useState(new Date(1609459200000));        //Horário inicial
    const [horaFinish, setHoraFinish] = useState(new Date(1609459200000));      //Horário final
    const [date, setDate] = useState('');                                       //Salva a data
    const [time, setTime] = useState('');                                       //Salva a hora
    var dia = new Date();                                                       //Dia, Mês e Ano

    // Funções de dentro da página

    function currencyReal(numero) {
        if (isNaN(numero)) {
            return num = 'R$';
        }

        var num = 0;
        num = parseFloat(numero).toFixed(2);
        num = num.split('.');
        num[0] = `R$ ${num[0].split(/(?=(?:...)*$)/).join('.')}`;
        num = num.join(',');
        return num;
    }

    // Função para adicionar 3 dias ao mínimo pedido
    Date.prototype.addDays = function (days) {
        let date = new Date();
        date.setDate(date.getDate() + days);
        return date;
    }

    // Setar o tempo
    const onChangeTime = (event, selectedTime) => {
        if (selectedTime === undefined) {
            selectedTime = dia.addDays(3);
        }
        const currentTime = selectedTime || time;
        setPeriod(Platform.OS === 'ios');
        setDate(currentTime);
        console.log('CURRENT TIME: ' + currentTime);
        setPeriod(false);
    }

    // Setar a data
    const onChangeDay = (event, selectedDate) => {
        if (selectedDate === undefined) {
            selectedDate = dia.addDays(3);
        }
        const currentDate = selectedDate || day;
        setDay(Platform.OS === 'ios');
        setDate(currentDate);
        console.log('CURRENT DATE: ' + currentDate);
        setDay(false);

    }

    // Executa ao carregar a página
    useEffect(() => {
        setDate(dia.addDays(3));
        setTime(dia.addDays(3));
        setShowDate(false);
        setHour(true);
        setFiltro('sem filtro');
    }, []);

    // Construção da página
    return (
        <>
            {/* Cabeçalho da página */}
            <ContainerTop>
                <ImageBackground
                    source={imgBanner}
                    style={{
                        width: '100%',
                        justifyContent: 'center',
                        alignItems: 'center'
                    }}
                >
                    <Container pb
                        style={{
                            flexDirection: 'column',
                            alignItems: 'center',
                            justifyContent: 'center',
                            width: '100%'
                        }}
                    >
                        <Image source={logo}
                            resizeMode="contain"
                            style={{
                                width: 150,
                                height: 150,
                                marginTop: -30,
                                marginBottom: -55,
                            }}
                        />
                        <TouchableOpacity
                            onPress={() => { console.log('Navegar para a homepage') }} //Navegar para a Home
                            style={{
                                position: 'absolute',
                                alignSelf: 'flex-start',
                                marginLeft: '5%',
                                alignContent: 'flex-start',
                                alignItems: 'flex-start',
                            }}
                        >
                            <FontAwesome5
                                name='chevron-left'
                                color={theme.colors.white}
                                size={40}
                            />
                        </TouchableOpacity>
                        <Text style={styles.textStyleF}>
                            RoboComp - Lista de Serviços
                        </Text>
                    </Container>
                </ImageBackground>
            </ContainerTop>
            {/* Meio da página */}
            <View style={{
                backgroundColor: '#F4F1F0',
                alignSelf: 'center',
                minWidth: '100%',
                height: '100%',
                alignItems: 'center'
            }}>
                <View style={{
                    flexDirection: 'column',
                    marginVertical: 20,
                    width: '100%',
                    alignItems: 'flex-start',
                    marginLeft: '7%',
                    marginRight: 0
                }}>
                    <View style={{
                        flexDirection: 'row',
                        alignItems: 'center',
                        paddingRight: '8%'
                    }}>
                        <View style={{ flexDirection: 'column' }}>
                            {(search === 'serviços') ?
                                <Text style={{ fontWeight: 'bold', marginLeft: 5 }}>Nome do Serviço:</Text>
                                :
                                <Text style={{ fontWeight: 'bold', marginLeft: 5 }}>Nome do Técnico:</Text>
                            }
                            <View style={styles.search}>
                                <TextInput
                                    value={search} //value={(search==='serviços')? text : text2}
                                    onChangeText={(t) => setSearch(t)} //onChangeText={(t)=>escolha(search, t)}
                                    style={styles.textInput}
                                />
                            </View>
                            <View style={{ flexDirection: 'row', alignItems: 'center' }}>
                                <TouchableWithoutFeedback
                                    style={styles.touchOptions}
                                    onPress={() => { setSearch('serviços') }}
                                >
                                    <RadioButton
                                        value="serviços"
                                        status={search === 'serviços' ? 'checked' : 'unchecked'}
                                        onPress={() => { }}
                                    />
                                    <Text>Serviços</Text>
                                </TouchableWithoutFeedback>
                                <TouchableWithoutFeedback
                                    style={styles.touchOptions}
                                    onPress={() => { setSearch('técnicos') }}
                                >
                                    <RadioButton
                                        value='técnicos'
                                        status={search === 'técnicos' ? 'checked' : 'unchecked'}
                                        onPress={() => { }}
                                    />
                                    <Text>Técnicos</Text>
                                </TouchableWithoutFeedback>
                            </View>
                        </View>

                        <TouchableOpacity onPress={() => { setShow(true); setShow2(true) }}>
                            {/* Adicionar a pesquisa de serviços na linha acima */}
                            <FontAwesome5
                                name='search'
                                colors={theme.colors.black}
                                size={40}
                            />
                        </TouchableOpacity>
                    </View>
                    <View style={{ flexDirection: 'row' }}>
                        <View>
                            {(show && show2) ? (
                                // Ambas opções fechadas
                                <View style={{ marginBottom: 15 }}>
                                    <View style={{ flexDirection: 'row', width: '95%' }}>
                                        <TouchableOpacity
                                            style={styles.filter}
                                            onPress={() => { setShow(!show) }}
                                        >
                                            <FontAwesome5
                                                name='chevron-right'
                                                color={theme.colors.black}
                                                size={20}
                                            />
                                            <Text style={{ fontWeight: 'bold', marginHorizontal: 5 }}>Categorias</Text>
                                        </TouchableOpacity>
                                        <TouchableOpacity
                                            style={styles.filter}
                                            onPress={() => { setShow2(!show2) }}
                                        >
                                            <FontAwesome5
                                                name='chevron-right'
                                                color={theme.colors.black}
                                                size={20}
                                            />
                                            <Text style={{ fontWeight: 'bold', marginLeft: 5 }}>Filtros</Text>
                                        </TouchableOpacity>
                                        <TouchableOpacity
                                            onPress={() => console.log('Navegar para o carrinho de compras')}
                                            style={styles.filter2}
                                        >
                                            <FontAwesome5
                                                name='shopping-cart'
                                                color={theme.colors.black}
                                                size={30}
                                            />
                                            <Text style={{ fontWeight: 'bold', marginLeft: 5 }}>0</Text>
                                        </TouchableOpacity>
                                    </View>
                                </View>
                            ) : (!show && show2) ? (
                                // Aba de opções de escolha para categorias
                                <View>
                                    <View style={{ flexDirection: 'row', width: '95%' }}>
                                        <TouchableOpacity
                                            style={styles.filter}
                                            onPress={() => { setShow(!show) }}
                                        >
                                            <FontAwesome5
                                                name='chevron-down'
                                                color={theme.colors.black}
                                                size={20}
                                            />
                                            <Text style={{ fontWeight: 'bold', marginHorizontal: 5 }}>Categorias</Text>
                                        </TouchableOpacity>
                                        <TouchableOpacity
                                            style={styles.filter}
                                            onPress={() => { setShow2(!show2); setShow(!show) }}
                                        >
                                            <FontAwesome5
                                                name='chevron-right'
                                                color={theme.colors.black}
                                                size={20}
                                            />
                                            <Text style={{ fontWeight: 'bold', marginLeft: 5 }}>Filtros</Text>
                                        </TouchableOpacity>
                                        <TouchableOpacity
                                            onPress={() => console.log('Navegar para o carrinho de compras')}
                                            style={styles.filter2}
                                        >
                                            <FontAwesome5
                                                name='shopping-cart'
                                                color={theme.colors.black}
                                                size={30}
                                            />
                                            <Text style={{ fontWeight: 'bold', marginLeft: 5 }}>1</Text>
                                        </TouchableOpacity>
                                    </View>
                                    <View style={{ marginBottom: 15 }}>
                                        {/* Opções para as categorias, vem do banco de dados as opções */}
                                        {/* {arrayCategory.map((cate) => (
                                            <View key = {cate.id} style={{flexDirection:'row', alignItems: 'baseline'}}>
                                                <RadioButton
                                                    value={cate.category_name}
                                                    status={show2[cate.id-1] ? 'checked' : 'unchecked'}
                                                    onPress={()=>{
                                                        changeState(cate.id-1);
                                                        setSelect(cate.category_name);
                                                        console.log(JSON.stringify(select));
                                                    }}
                                                />
                                                <Text style={{color:'#000'}}>{cate.category_name}</Text>
                                            </View>
                                        ))} */}

                                    </View>
                                </View>
                            ) : (
                                // Aba de opções de escolha de filtros
                                <View style={{ marginBottom: 15 }}>
                                    <View style={{ flexDirection: 'row', width: '95%' }}>
                                        <TouchableOpacity
                                            style={styles.filter}
                                            onPress={() => { setShow2(!show2); setShow(!show) }}
                                        >
                                            <FontAwesome5
                                                name='chevron-right'
                                                color={theme.colors.black}
                                                size={20}
                                            />
                                            <Text style={{ fontWeight: 'bold', marginHorizontal: 5 }}>Categorias</Text>
                                        </TouchableOpacity>
                                        <TouchableOpacity
                                            style={styles.filter}
                                            onPress={() => { setShow2(!show2); }}
                                        >
                                            <FontAwesome5
                                                name='chevron-down'
                                                color={theme.colors.black}
                                                size={20}
                                            />
                                            <Text style={{ fontWeight: 'bold', marginLeft: 5 }}>Filtros</Text>
                                        </TouchableOpacity>
                                        <TouchableOpacity
                                            onPress={() => { console.log('navegar para o carrinho de compras') }}
                                            style={styles.filter2}>
                                            <FontAwesome5
                                                name='shopping-cart'
                                                color={theme.colors.black}
                                                size={30}
                                            />
                                            <Text style={{ fontWeight: 'bold', marginLeft: 5 }}>2</Text>
                                        </TouchableOpacity>
                                    </View>
                                    <View>
                                        <View style={{ flexDirection: 'row', alignItems: 'baseline', height: 30 }}>
                                            <TouchableWithoutFeedback
                                                style={styles.touchOptions}
                                                onPress={() => { setFiltro('sem filtro') }}
                                            >
                                                <RadioButton
                                                    value={'sem filtro'}
                                                    status={(filtro === 'sem filtro') ? 'checked' : 'unchecked'}
                                                    onPress={() => { }}
                                                />
                                                <Text style={{ alignSelf: 'center' }}>Sem filtro</Text>
                                            </TouchableWithoutFeedback>
                                        </View>
                                        <View style={{ flexDirection: 'row', alignItems: 'baseline', height: 30 }}>
                                            <TouchableWithoutFeedback
                                                style={styles.touchOptions}
                                                onPress={() => { setFiltro('qualification') }}
                                            >
                                                <RadioButton
                                                    value={'qualification'}
                                                    status={(filtro === 'qualification') ? 'checked' : 'unchecked'}
                                                    onPress={() => { }}
                                                />
                                                <Text style={{ alignSelf: 'center' }}>Ordenar por qualificação</Text>
                                            </TouchableWithoutFeedback>
                                        </View>
                                        <View style={{ flexDirection: 'row', alignItems: 'baseline', height: 30 }}>
                                            <TouchableWithoutFeedback
                                                style={styles.touchOptions}
                                                onPress={() => { setFiltro('price') }}
                                            >
                                                <RadioButton
                                                    value={'price'}
                                                    status={(filtro === 'price') ? 'checked' : 'unchecked'}
                                                    onPress={() => { }}
                                                />
                                                <Text style={{ alignSelf: 'center' }}>Ordenar por preço (do menor para maior)</Text>
                                            </TouchableWithoutFeedback>
                                        </View>
                                        <View style={{ flexDirection: 'row', alignItems: 'baseline', height: 30 }}>
                                            <TouchableWithoutFeedback
                                                style={styles.touchOptions}
                                                onPress={() => { setFiltro('quantity') }}
                                            >
                                                <RadioButton
                                                    value={'quantity'}
                                                    status={(filtro === 'quantity') ? 'checked' : 'unchecked'}
                                                    onPress={() => { }}
                                                />
                                                <Text style={{ alignSelf: 'center' }}>Quantidade de serviços realizados</Text>
                                            </TouchableWithoutFeedback>
                                        </View>
                                        <View style={{ flexDirection: 'row', alignItems: 'baseline', height: 30 }}>
                                            <TouchableWithoutFeedback
                                                style={styles.touchOptions}
                                                onPress={() => { setFiltro('distance') }}
                                            >
                                                <RadioButton
                                                    value={'distance'}
                                                    status={(filtro === 'distance') ? 'checked' : 'unchecked'}
                                                    onPress={() => { }}
                                                />
                                                <Text style={{ alignSelf: 'center' }}>Distância (do menor para o maior)</Text>
                                            </TouchableWithoutFeedback>
                                        </View>
                                    </View>
                                </View>
                            )}
                        </View>
                    </View>
                    <ScrollView style={
                        (show && show2) ? styles.scrollView :
                            (show) ? styles.scrollView2 : styles.scrollView3
                    }>
                        {/* Cards de serviços */}
                        <View>
                            {/* {(services !== undefined) ? services.map((serv, index) => ( //Inicialização do map de serviços */}
                            <TouchableOpacity
                                style={styles.anuncioCard}
                                onPress={() => console.log('ID do serviço')} //onPress={() => { selectService(serv.id); }}
                            >
                                {/* Imagem */}
                                <View style={styles.imageInfo}>
                                    <Image style={styles.imageCard} source={imgTeste} />
                                </View>
                                <View style={styles.adInfo}>
                                    {/* Título */}
                                    <Text style={styles.adTitle}>Título</Text>
                                    {/* Preço */}
                                    <Text style={styles.adPrice}>R$10,00</Text>
                                    {/* Nome do servidor/técnico */}
                                    <Text>Arthur</Text>
                                    {/* Categoria do anúncio */}
                                    <View style={{
                                        flexDirection: 'row',
                                        marginBottom: 10,
                                        marginRight: 10,
                                        marginTop: 'auto',
                                    }}>
                                        <Text style={styles.adCategory}>Categoria</Text>
                                    </View>
                                </View>
                                {/* Botão para adicionar direto ao carrinho */}
                                <View style={{ marginVertical: 10, alignItems: 'center' }}>
                                    <TouchableOpacity
                                        style={{ marginTop: 0, marginBottom: 'auto' }}
                                        onPress={() => {
                                            setShowDate(true);
                                            setDay(true);
                                            console.log('setShowDate(true)\nset ID do cliente\nset subcategoria\nset do preço')
                                            setDate(dia.addDays(3));
                                            setTime(dia.addDays(3));
                                        }}
                                    >
                                        <FontAwesome5
                                            name='cart-plus'
                                            color={theme.colors.black}
                                            size={24}
                                        />
                                    </TouchableOpacity>
                                    <View style={{ marginLeft: -15 }}>
                                        <Fontisto
                                            name='star'
                                            size={40}
                                            color={theme.colors.star}
                                        />
                                        <Text style={{
                                            position: 'absolute',
                                            alignSelf: 'center',
                                            paddingTop: '33%'
                                        }}>4.5</Text>
                                    </View>
                                </View>
                                <Portal>
                                    <Dialog visible={showDate} onDismiss={() => { setShowDate(false), setHour(true), setDay(false), setPeriod(false) }}>
                                        <Dialog.Title>Selecione uma data:
                                        </Dialog.Title>
                                        <Dialog.Content>{(hour) ?
                                            <>
                                                <View style={{ flexDirection: 'row' }}>
                                                    <Input
                                                        style={{ width: '20%', textAlign: 'center', marginHorizontal: 5 }}
                                                        mode='flat'
                                                        label="Dia"
                                                        value={date.toString().substring(8, 10)}
                                                        onFocus={() => setDay(true)}
                                                    />
                                                    <Input
                                                        style={{ width: '20%', textAlign: 'center', marginHorizontal: 5 }}
                                                        mode='flat'
                                                        label="Mês"
                                                        value={date.toString().substring(4, 7)}
                                                        onFocus={() => setDay(true)}
                                                    />
                                                    <Input
                                                        style={{ width: '20%', textAlign: 'center', marginHorizontal: 5 }}
                                                        mode='flat'
                                                        label="Ano"
                                                        value={date.toString().substring(11, 15)}
                                                        onFocus={() => setDay(true)}
                                                    />
                                                    <TouchableOpacity
                                                        style={{ alignSelf: 'center', marginLeft: 'auto', marginRight: '4%' }}
                                                        onPress={() => { setHour(!hour); console.log('DATA: ' + date); }}
                                                    >
                                                        <FontAwesome5
                                                            name='chevron-right'
                                                            size={40}
                                                            color={theme.colors.contrast}
                                                        />
                                                    </TouchableOpacity>
                                                </View>
                                                {day && <DateTimePicker
                                                    value={date}
                                                    mode='date'
                                                    minimumDate={date}
                                                    onChange={onChangeDay}
                                                />}
                                            </>
                                            :
                                            <>
                                                <View style={{ flexDirection: 'row' }}>
                                                    <Input
                                                        style={{ width: '20%', textAlign: 'center', marginHorizontal: 5 }}
                                                        mode='flat'
                                                        label="Hora"
                                                        value={date.toString().substring(16, 18)}
                                                        onFocus={() => setPeriod(true)}
                                                        onChangeText={() => setPeriod(true)}
                                                    />
                                                    <Input
                                                        style={{ width: '20%', textAlign: 'center', marginHorizontal: 5 }}
                                                        mode='flat'
                                                        label="Minuto"
                                                        value={date.toString().substring(19, 21)}
                                                        onFocus={() => setPeriod(true)}
                                                        onChangeText={() => setPeriod(true)}
                                                    />
                                                    <TouchableOpacity
                                                        style={{ alignSelf: 'center', marginLeft: 'auto', marginRight: '4%' }}
                                                        onPress={() => { console.log('ADD no carrinho: ID, sub, preço, data:' + date); setHour(!hour); setShowDate(false) }}
                                                    >
                                                        <FontAwesome5
                                                            name='chevron-circle-right'
                                                            size={40}
                                                            color={theme.colors.contrast}
                                                        />
                                                    </TouchableOpacity>
                                                </View>
                                                {period && <DateTimePicker
                                                    value={date}
                                                    mode={'time'}
                                                    is24Hour={true}
                                                    onChange={onChangeTime}
                                                />}
                                            </>
                                        }
                                        </Dialog.Content>
                                    </Dialog>
                                </Portal>
                            </TouchableOpacity>
                            {/* )) : <View /> */}
                        </View>
                    </ScrollView>
                </View>
            </View>
        </>
    );
};

const styles = StyleSheet.create({
    textStyleF: {
        fontSize: 16,
        paddingLeft: 20,
        paddingRight: 20,
        color: 'white',
        textAlign: 'center',
        padding: 3,
    },
    scrollView: {
        backgroundColor: '#F4F1F0',
        marginHorizontal: 0,
        paddingTop: 5,
        flexGrow: 1,
        marginBottom: '43%',
    },
    scrollView2: {
        backgroundColor: '#F4F1F0',
        marginHorizontal: 0,
        paddingTop: 5,
        flexGrow: 1,
        height: '46%',
    },
    scrollView3: {
        backgroundColor: '#F4F1F0',
        marginHorizontal: 0,
        paddingTop: 5,
        flexGrow: 1,
        height: '32%',
    },
    adInfo: {
        width: '55%',
        marginTop: 5,
    },
    anuncioCard: {
        flexDirection: 'row',
        height: 160,
        width: '97%',
        marginBottom: 10,
        borderRadius: 20,
        backgroundColor: '#FFF',
    },
    imageInfo: {
        width: '30%',
        height: '100%',
        marginRight: '3%',
    },
    imageCard: {
        width: '100%',
        height: '100%',
        borderTopLeftRadius: 20,
        borderBottomLeftRadius: 20,
        borderWidth: 1,
        borderColor: theme.colors.black,
    },
    deleteIcon: {
        alignSelf: 'flex-start',
        marginRight: '2%',
        marginTop: '2%',
    },
    editIcon: {
        marginTop: '2%',
        marginBottom: '55%',
    },
    adTitle: {
        fontWeight: 'bold',
        marginRight: '30%',
    },
    adPrice: { fontWeight: 'bold', marginTop: 20 },
    adCategory: {
        textAlign: 'justify',
        height: 'auto',
        width: '60%',
    },
    filter: {
        flexDirection: 'row',
        alignItems: 'center',
        width: '30%'
    },
    filter2: {
        flexDirection: 'row',
        alignItems: 'center',
        marginRight: 5,
        marginLeft: 'auto',
    },
    search: {
        flexDirection: 'row',
        alignItems: 'center',
        marginVertical: 5,
    },
    textInput: {
        height: 30,
        marginLeft: 5,
        width: '80%',
        borderRadius: 8,
        borderColor: 'transparent',
        borderWidth: 1,
        backgroundColor: '#FFF',
    },
    touchOptions: {
        flexDirection: 'row',
        alignItems: 'center',
    },
});